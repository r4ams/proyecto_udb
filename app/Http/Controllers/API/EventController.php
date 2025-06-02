<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;

class EventController extends Controller
{
    public function index()
    {
        return Event::with('user', 'rsvps', 'comments')->orderBy('date')->get();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'location' => 'required|string',
            'date' => 'required|date',
            'time' => 'required'
        ]);

        $event = Event::create([
            ...$data,
            'user_id' => $request->user()->id
        ]);

        return response()->json($event, 201);
    }

    public function show(Event $event)
    {
        return $event->load('user', 'rsvps.user', 'comments.user');
    }

    public function update(Request $request, Event $event)
    {
        // $this->authorize('update', $event);

        $event->update($request->only(['title', 'description', 'location', 'date', 'time']));

        return response()->json($event);
    }

    public function destroy(Event $event)
    {
        $this->authorize('delete', $event);

        $event->delete();

        return response()->json(['message' => 'Evento eliminado']);
    }

}
