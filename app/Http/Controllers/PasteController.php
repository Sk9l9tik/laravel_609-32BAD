<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Paste;
use Illuminate\Support\Facades\Auth;

class PasteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perpage = (int) $request->query('perpage', 5);
        $perpage = max(1, min($perpage, 100));
        $pastes = Paste::orderBy('id', 'desc')->paginate($perpage)->withQueryString();
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
            'access' => 'required|in:public,private',
            'expiration' => 'nullable|integer|min:1',
        ]);

        // привязываем к пользователю при наличии
        if (Auth::check()) {
            $data['user_id'] = Auth::id();
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

        // опциональная проверка владельца
        if (Auth::check() && isset($paste->user_id) && Auth::id() !== $paste->user_id) {
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

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'main_text' => 'required|string',
            'access' => 'required|in:public,private',
            'expiration' => 'nullable|integer|min:1',
        ]);

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

        // удалить связанные данные, если нужно
        if (method_exists($paste, 'comments')) {
            $paste->comments()->delete();
        }

        $paste->delete();

        // важно: используем ключ 'success' (или тот, что в partial)
        return redirect()->route('paste.index')->with('success', 'Запись успешно удалена.');
    }
}