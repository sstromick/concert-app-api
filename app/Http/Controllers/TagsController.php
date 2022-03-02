<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tag;
use App\Http\Requests\Tag\TagStoreRequest;
use App\Http\Requests\Tag\TagUpdateRequest;

class TagsController extends Controller
{
    public function index() {
        $tags = Tag::getFilteredTags();
        return response()->json(['data' => $tags], 200);
    }

    public function store(TagStoreRequest $request) {
        $attributes = $request->validated();
        $tag = Tag::create($attributes);
        $tags = Tag::where('tagable_type', '=', $tag->tagable_type)
            ->where('tagable_id', '=', $tag->tagable_id)
            ->paginate(20);
        return response()->json(['data' => $tags, 'message' => 'Tag created'], 201);
    }

    public function show(Tag $tag) {
        return response()->json(['data' => $tag], 200);
    }

    public function update(TagUpdateRequest $request, Tag $tag) {
        $attributes = $request->validated();
        $tag->update($attributes);
        return response()->json(['data' => $tag, 'message' => 'Tag updated'], 200);
    }

    public function destroy(Tag $tag) {
        $tag->delete();
        return response()->json(['data' => $tag, 'message' => 'Tag deleted'], 200);
    }

    public function export() {
        $tags = Tag::getFilteredTags();
        return $this->createExport($tags, "tags");
    }
}
