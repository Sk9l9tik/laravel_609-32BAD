<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Paste;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon; 

class PasteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perpage = (int) $request->query('perpage', 5);
        $perpage = max(1, min($perpage, 100));

        $query = Paste::orderBy('id', 'desc');

        if (Auth::check()) {
            if (Schema::hasColumn('pastes', 'author_id')) {
                $query->where('author_id', Auth::id());
            } elseif (Schema::hasColumn('pastes', 'user_id')) {
                $query->where('user_id', Auth::id());
            }
        }

        $pastes = $query->paginate($perpage)->withQueryString();
        return view('pastes', compact('pastes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('create_paste');
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

        $data['access'] = in_array($data['access'], ['1', 1, 'public', 'true', true], true) ? true : false;

        if (! empty($data['expiration']) && is_numeric($data['expiration'])) {
            $data['expiration'] = Carbon::now()->addHours((int) $data['expiration']);
        } elseif (! empty($data['expiration'])) {
            $data['expiration'] = Carbon::parse($data['expiration']);
        } else {
            $data['expiration'] = null;
        }

        if (Auth::check()) {
            if (Schema::hasColumn('pastes', 'author_id')) {
                $data['author_id'] = Auth::id();
            } elseif (Schema::hasColumn('pastes', 'user_id')) {
                $data['user_id'] = Auth::id();
            }
        }

        $paste = Paste::create($data);

        return redirect()->route('paste.index')->with('success', 'Запись создана.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $paste = Paste::find($id);
        if (! $paste) {
            return redirect()->route('paste.index')->with('error', 'Запись не найдена');
        }

        if (! $paste->access) {
            if (! Auth::check()) {
                return redirect()->route('paste.index')->with('error', 'Доступ запрещён');
            }

            $ownerId = null;
            if (Schema::hasColumn('pastes', 'author_id') && isset($paste->author_id)) {
                $ownerId = $paste->author_id;
            } elseif (Schema::hasColumn('pastes', 'user_id') && isset($paste->user_id)) {
                $ownerId = $paste->user_id;
            }

            if ($ownerId === null || Auth::id() !== (int) $ownerId) {
                return redirect()->route('paste.index')->with('error', 'Доступ запрещён');
            }
        }

        return view('paste', compact('paste'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $paste = Paste::find($id);
        if (! $paste) {
            return redirect()->route('paste.index')->with('error', 'Запись не найдена');
        }

        if (Auth::check()) {
            $ownerId = null;
            if (Schema::hasColumn('pastes', 'author_id') && isset($paste->author_id)) {
                $ownerId = $paste->author_id;
            } elseif (Schema::hasColumn('pastes', 'user_id') && isset($paste->user_id)) {
                $ownerId = $paste->user_id;
            }

            if ($ownerId !== null && Auth::id() !== (int) $ownerId) {
                return redirect()->route('paste.index')->with('error', 'Доступ запрещён');
            }
        } else {
            return redirect()->route('paste.index')->with('error', 'Доступ запрещён');
        }

        return view('edit_paste', compact('paste'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $paste = Paste::find($id);
        if (! $paste) {
            return redirect()->route('paste.index')->with('error', 'Запись не найдена');
        }

        if (! Auth::check()) {
            return redirect()->route('paste.index')->with('error', 'Доступ запрещён');
        }

        $ownerId = null;
        if (Schema::hasColumn('pastes', 'author_id') && isset($paste->author_id)) {
            $ownerId = $paste->author_id;
        } elseif (Schema::hasColumn('pastes', 'user_id') && isset($paste->user_id)) {
            $ownerId = $paste->user_id;
        }

        if ($ownerId === null || Auth::id() !== (int) $ownerId) {
            return redirect()->route('paste.index')->with('error', 'Доступ запрещён');
        }

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'main_text' => 'required|string',
            'access' => 'required|in:0,1,public,private',
            'expiration' => 'nullable',
        ]);

        $data['access'] = in_array($data['access'], ['1', 1, 'public', 'true', true], true) ? true : false;

        if (! empty($data['expiration']) && is_numeric($data['expiration'])) {
            $data['expiration'] = Carbon::now()->addHours((int) $data['expiration']);
        } elseif (! empty($data['expiration'])) {
            $data['expiration'] = Carbon::parse($data['expiration']);
        } else {
            $data['expiration'] = null;
        }

        $paste->update($data);

        return redirect()->route('paste.index')->with('success', 'Запись обновлена.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $paste = Paste::find($id);
        if (! $paste) {
            return redirect()->route('paste.index')->with('error', 'Запись не найдена.');
        }

        if (! Auth::check()) {
            return redirect()->route('paste.index')->with('error', 'Доступ запрещён');
        }

        $ownerId = null;
        if (Schema::hasColumn('pastes', 'author_id') && isset($paste->author_id)) {
            $ownerId = $paste->author_id;
        } elseif (Schema::hasColumn('pastes', 'user_id') && isset($paste->user_id)) {
            $ownerId = $paste->user_id;
        }

        if ($ownerId === null || Auth::id() !== (int) $ownerId) {
            return redirect()->route('paste.index')->with('error', 'Доступ запрещён');
        }

        if (method_exists($paste, 'comments')) {
            $paste->comments()->delete();
        }

        $paste->delete();

        return redirect()->route('paste.index')->with('success', 'Запись успешно удалена.');
    }
}