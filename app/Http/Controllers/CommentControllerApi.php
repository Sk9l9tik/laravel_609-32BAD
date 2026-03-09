<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;

class CommentControllerApi extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, $id) {
        return Comment::where('paste_id', $id)
            ->with('user:id,name')   // ← add this
            ->limit($request->perpage ?? 6)
            ->offset(($request->perpage ?? 6) * ($request->page ?? 0))
            ->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $id)
    {

        return Comment::create([
            'paste_id' => $id,
            'author_id' => $request->user()->id,
            'text' => $request->text,
        ]);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return response(Comment::find($id));
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

    public function total($id) {
        return Comment::where('paste_id', $id)->count();
    }

}
