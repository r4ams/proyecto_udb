<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Comment;

class CommentController extends Controller
{
    public function index(Event $event)
    {
        return $event->comments()->with('user')->get();
    }

    public function store(Request $request, Event $event)
    {
        $request->validate([
            'comment' => 'required|string',
            'rating' => 'required|integer|min:1|max:5'
        ]);

        $comment = Comment::create([
            'user_id' => $request->user()->id,
            'event_id' => $event->id,
            'comment' => $request->comment,
            'rating' => $request->rating
        ]);

        return response()->json($comment, 201);
    }
}
