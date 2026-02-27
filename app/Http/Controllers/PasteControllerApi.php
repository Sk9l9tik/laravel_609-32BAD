<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Paste;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

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
            'title' => 'required|string|max:255',
            'main_text' => 'required|string',
            'access' => 'required|in:0,1,public,private',
            'expiration' => 'nullable',
        ]);

        do {
            $data['id'] = random_int(1, 10000001);  // e.g., "A1B2C3D4"
        } while (Paste::where('id', $data['id'])->exists());

        $data['access'] = in_array($data['access'], ['1', 1, 'public', 'true', true], true) ? true : false;

        if (! empty($data['expiration']) && is_numeric($data['expiration'])) {
            $data['expiration'] = Carbon::now()->addHours((int) $data['expiration']);
        } elseif (! empty($data['expiration'])) {
            $data['expiration'] = Carbon::parse($data['expiration']);
        } else {
            $data['expiration'] = null;
        }

        // if (Auth::check()) {
        //     if (Schema::hasColumn('pastes', 'author_id')) {
        //         $data['author_id'] = Auth::id();
        //     } elseif (Schema::hasColumn('pastes', 'user_id')) {
        //         $data['user_id'] = Auth::id();
        //     }
        // }
        $data['author_id'] = $request->user() ? $request->user()->id : 2;

        $paste = Paste::create($data);

        return response()->json([
            'success' => true,
            'id' => $paste->id,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return response(Paste::find($id));
        // return response(Paste::with('comments')->find($id));
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
}
