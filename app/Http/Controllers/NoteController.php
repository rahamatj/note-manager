<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Note;
use Inertia\Inertia;

class NoteController extends Controller
{
    public function index()
    {
        return inertia('Notes/Index');
    }

    public function notes(Request $request)
    {
        $notes = $request->user()->notes;

        return inertia('Dashboard', [
            'notes' => $notes,
        ]);
    }

    public function store(Request $request)
    {
        $data = request()->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $note = \Auth::user()->notes()->create($data);

        return response()->json(['success' => 'Note created successfully.']);
    }

    public function getNotes(Request $request)
    {
        $notes = $request->user()->notes;

        return inertia('Notes/Index', [
            'notes' => $notes,
        ]);
    }

    public function show($id)
    {
        $note = Note::findOrFail($id);

        if (! $note) {
            return Inertia::render('Dashboard', [
                'message' => 'Note not found.',
            ]);
        }

        return Inertia::render('Notes/Show', [
            'note' => $note,
        ]);
    }

    public function edit($id)
    {
        return Inertia::render('Notes/Edit', [
            'note' => Note::findOrFail($id),
        ]);
    }

    public function update(Request $request, $id)
    {
        $note = $request->user()->notes()->findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $note->update($request->only('title', 'content'));

        return response()->json(['note' => $note, 'success'=> 'Note updated successfully.']);
    }

    public function destroy(Request $request, $id)
    {
        $note = $request->user()->notes()->findOrFail($id);
        $note->delete();

        return redirect()->route('notes.index')->with('success', 'Note deleted successfully.');
    }
}
