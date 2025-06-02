<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\EventUser;
use App\Models\RSVP;
use Illuminate\Support\Facades\Auth;


class RSVPController extends Controller
{
    public function store(Request $request, Event $event)
    {
        $request->validate([
            'status' => 'required|in:attending,maybe,not_going',
        ]);

        $rsvp = RSVP::updateOrCreate(
            ['user_id' => $request->user()->id, 'event_id' => $event->id],
            ['status' => $request->status]
        );

        return response()->json(['message' => 'Asistencia registrada.', 'rsvp' => $rsvp]);
    }

    public function index(Event $event)
    {
        return $event->rsvps()->with('user')->get();
    }

    public function status($id)
    {
        $user = auth()->user();
        $event = Event::findOrFail($id);

        $rsvp = RSVP::where('event_id', $event->id)
            ->where('user_id', $user->id)
            ->first();

        return response()->json([
            'message' => 'Asistencia registrada.',
            'status' => $rsvp ? $rsvp->status : null
        ]);
    }
}