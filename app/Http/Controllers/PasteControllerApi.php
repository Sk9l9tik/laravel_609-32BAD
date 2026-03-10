<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Paste;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Configuration\Exceptions;

class PasteControllerApi extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return response(Paste::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title'      => 'required|string|max:255',
            'main_text'  => 'required|string',
            'access'     => 'required|in:0,1,public,private',
            'expiration' => 'nullable',
            'image'      => 'nullable|file|image|max:5120',
        ]);

        $fileUrl = null;
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $file     = $request->file('image');
            $fileName = rand(1, 100000) . '_' . $file->getClientOriginalName();
            try {
                $path    = Storage::disk('s3')->putFileAs('paste_pictures', $file, $fileName);
                $fileUrl = env('AWS_URL') . '/' . $path;

            } catch (\Exception $e) {
                return response()->json([
                    'code'    => 2,
                    'message' => 'File upload failed: ' . $e->getMessage(),
                ], 500);
            }
        }

        do {
            $data['id'] = random_int(1, 10000001);
        } while (Paste::where('id', $data['id'])->exists());

        $data['access'] = in_array($data['access'], ['1', 1, 'public', 'true', true], true);

        if (!empty($data['expiration']) && is_numeric($data['expiration'])) {
            $data['expiration'] = Carbon::now()->addHours((int) $data['expiration']);
        } elseif (!empty($data['expiration'])) {
            $data['expiration'] = Carbon::parse($data['expiration']);
        } else {
            $data['expiration'] = null;
        }

        $user = null;
        $token = $request->bearerToken();
        if ($token) {
            $accessToken = \Laravel\Sanctum\PersonalAccessToken::findToken($token);
            if ($accessToken) {
                $user = $accessToken->tokenable;
            }
        }

        $data['author_id'] = $user ? $user->id : 2;
        $data['image_url'] = $fileUrl;

        $paste = Paste::create($data);

        return response()->json([
            'success'   => true,
            'id'        => $paste->id,
            'image_url' => $paste->image_url,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {
        $paste = Paste::with('user:id,name')->find($id);

        if (!$paste) {
            return response()->json(['message' => 'Not found'], 404);
        }

        if ($paste->expiration && \Carbon\Carbon::now()->isAfter($paste->expiration)) {
            return response()->json(['message' => 'This paste has expired'], 410);
        }

        $user = null;
        $token = $request->bearerToken();
        if ($token) {
            $accessToken = \Laravel\Sanctum\PersonalAccessToken::findToken($token);
            if ($accessToken) {
                $user = $accessToken->tokenable;
            }
        }

        if (!$paste->access && (!$user || $user->id !== $paste->author_id)) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        return response()->json($paste);
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function user_pastes(Request $request)
    {
        $user = $request->user();
        if (!$user) {
            return response()->json(['error' => 'Authentication required'], 401);
        }

        $pastes = Paste::where('author_id', $user->id)
            ->where(function ($query) {
                $query->whereNull('expiration')
                      ->orWhere('expiration', '>', \Carbon\Carbon::now());
            })
            ->limit($request->perpage ?? 6)
            ->offset(($request->perpage ?? 6) * ($request->page ?? 0))
            ->get();

        return response()->json($pastes);
    }

    public function total_user_pastes(Request $request)
    {
        $user = $request->user();
        if (!$user) {
            return response()->json(['error' => 'Authentication required'], 401);
        }

        return Paste::where('author_id', $user->id)
            ->where(function ($query) {
                $query->whereNull('expiration')
                      ->orWhere('expiration', '>', \Carbon\Carbon::now());
            })
            ->count();
    }
}
