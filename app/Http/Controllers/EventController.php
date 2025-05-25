<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\EventImage;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $user = auth()->user();
        $joinedEventIds = [];

        if ($user) {
            $joinedEventIds = $user->joinedEvents()->pluck('event_id')->toArray();
        }

        $events = Event::with('headImage')
            ->get()
            ->sortBy(function ($event) use ($joinedEventIds) {
                return [
                    !in_array($event->id, $joinedEventIds), // false (0) for joined = higher priority
                    $event->scheduled_time, // secondary sort
                ];
            });

        return view('events.index', compact('events', 'joinedEventIds'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        $event = Event::with('images')->findOrFail($event->id);
        $user = auth()->user();
        $joined = false;

        if ($user) {
            $joined = $event->participants()->where('user_id', $user->id)->exists();
        }
        return view('events.show', compact('event', 'joined'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        //
    }

    public function myEvents()
    {
        $user = auth()->user();
        // Get events the user joined, with eager loading if needed
        $events = $user->joinedEvents()
            ->with('headImage')
            ->orderBy('scheduled_time')
            ->get();

        return view('events.my-events', compact('events'));
    }

    public function join(Event $event)
    {
        $user = auth()->user();

        // Only allow joining planned events
        if ($event->status !== 'planned') {
            return redirect()->back()->with('error', 'You cannot join this event.');
        }

        // Check if already joined
        if ($event->participants()->where('user_id', $user->id)->exists()) {
            return redirect()->back()->with('info', 'You have already joined this event.');
        }

        // Check if event is full
        $currentCount = $event->participants()->count();
        if ($currentCount >= $event->capacity) {
            // Optionally update status to 'full'
            $event->update(['status' => 'full']);

            return redirect()->back()->with('error', 'The event is full. You cannot join.');
        }

        // Join the event
        $event->participants()->attach($user->id);

        // Update status if just reached full
        if ($currentCount + 1 >= $event->capacity) {
            $event->update(['status' => 'full']);
        }

        return redirect()->back()->with('success', 'You have successfully joined the event!');
    }

    public function cancelJoin(Event $event)
    {
        $user = auth()->user();
        $user->joinedEvents()->detach($event->id);

        return redirect()->route('events.show', $event->id)->with('success', 'You have cancelled your participation in this event.');
    }
}
