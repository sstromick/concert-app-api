<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Note;
use App\Http\Requests\Note\NoteStoreRequest;
use App\Http\Requests\Note\NoteUpdateRequest;

class NotesController extends Controller
{
    public function index() {
        $notes = Note::getFilteredNotes();
        return response()->json(['data' => $notes], 200);
    }

    public function store(NoteStoreRequest $request) {
        $attributes = $request->validated();
        $note = Note::create($attributes);
        $notes = Note::where('noteable_type', '=', $note->noteable_type)
                ->where('noteable_id', '=', $note->noteable_id)
                ->paginate(20);
        return response()->json(['data' => $notes, 'message' => 'Note created'], 201);
    }

    public function show(Note $note) {
        return response()->json(['data' => $note], 200);
    }

    public function update(NoteUpdateRequest $request, Note $note) {
        $attributes = $request->validated();
        $note->update($attributes);
        return response()->json(['data' => $note, 'message' => 'Note updated'], 200);
    }

    public function destroy(Note $note) {
        $note->delete();
        return response()->json(['data' => $note, 'message' => 'Note deleted'], 200);
    }

    public function export() {
        $notes = Note::getFilteredNotes(true);
        return $this->createExport($notes, "notes");
    }
}
