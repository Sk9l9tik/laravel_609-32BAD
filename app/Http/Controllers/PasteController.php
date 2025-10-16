<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Paste;

class PasteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perpage = $request->perpage ?? 2;
        return view('pastes', [
            'pastes' =>Paste::paginate($perpage)->withQueryString()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('create_paste') ;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required',
            'main_text' => '',
            'expiration' => 'required|integer',
            'access' => 'required'
        ]);

        // Преобразуем количество часов в временную метку
        $expirationTimestamp = now()->addHours((int)$validated['expiration']);

        $paste = new Paste([
            'title' => $validated['title'],
            'main_text' => $validated['main_text'],
            'expiration' => $expirationTimestamp,
            'access' => $validated['access'],
            'author_id' => auth()->id() ?? 3 
        ]);
        $paste->save();

        return redirect("/paste");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('paste', [
            'paste' => Paste::all()->where('id', $id)->first()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $paste = Paste::findOrFail($id);
        return view('edit_paste', compact('paste'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'main_text' => '',
            'expiration' => 'required',
            'access' => 'required'
        ]);

        $paste = Paste::findOrFail($id);
        $paste->title = $validated['title'];
        $paste->main_text = $validated['main_text'];
        $paste->expiration = $validated['expiration'];
        $paste->access = $validated['access'];
        $paste->save();

        return redirect('/paste');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $paste = Paste::findOrFail($id);
        $paste->comments()->delete();
        $paste->delete();
        return redirect('/paste');
    }
}