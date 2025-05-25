<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\EventImage;

use App\Notifications\EventAddedNotification;
use App\Notifications\EventUpdatedNotification;
use App\Notifications\EventRemovedNotification;
use App\Models\User;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = Event::with('headImage')->get();
        return view('admin.events.index', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.events.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
            'scheduled_time' => 'nullable|string',
            'capacity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'status' => 'required|in:planned,canceled,full',
            'tags' => 'nullable|string',
            'images.*' => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $tags = array_map('trim', explode(',', $request->input('tags')));
        $event = Event::create([
            'name' => $request->name,
            'description' => $request->description,
            'scheduled_time' => $request->scheduled_time,
            'capacity' => $request->capacity,
            'price' => $request->price,
            'status' => $request->status,
            'tags' => $tags,
        ]);


        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $data = base64_encode(file_get_contents($image));

                EventImage::create([
                    'event_id' => $event->id,
                    'base64' => $data,
                    'is_head' => $index === 0, // First one is the head
                ]);
            }
        }

        // Notify users about the new event
        $this->notifyAllUsers(EventAddedNotification::class, $event);

        return redirect()->route('admin.events.index')->with('success', 'Event created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $event = Event::with('images')->findOrFail($id);
        return view('events.show', compact('event'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        $event->load('images');
        return view('admin.events.edit', compact('event'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {
        $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
            'scheduled_time' => 'nullable|string',
            'capacity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'status' => 'required|in:planned,canceled,full',
            'tags' => 'nullable|string',
            'images.*' => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $tags = array_filter(array_map('trim', explode(',', $request->input('tags'))));
        $event->update([
            'name' => $request->name,
            'description' => $request->description,
            'scheduled_time' => $request->scheduled_time,
            'capacity' => $request->capacity,
            'price' => $request->price,
            'status' => $request->status,
            'tags' => $tags,
        ]);
        if ($request->hasFile('images')) {
            // Delete old images
            $event->images()->delete();

            foreach ($request->file('images') as $index => $image) {
                $data = base64_encode(file_get_contents($image));
                $event->images()->create([
                    'base64' => $data,
                    'is_head' => $index === 0,
                ]);
            }
        }

        // Notify users about the event update
        $this->notifyJoinedUsers(EventUpdatedNotification::class, $event);

        return redirect()->route('admin.events.index')->with('success', 'Event updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        $event->images()->delete(); // optional: clean up
        $event->delete();
        // Notify users about the event removal
        $this->notifyJoinedUsers(EventRemovedNotification::class, $event);

        return back()->with('success', 'Event deleted');
    }


    function notifyAllUsers($notification, $event)
    {
        $users = User::all();
        foreach ($users as $user) {
            $user->notify(new $notification($event));
        }
    }

    function notifyJoinedUsers($notification, Event $event)
    {
        $joinedUsers = $event->participants()->get();

        foreach ($joinedUsers as $user) {
            $user->notify(new $notification($event));
        }
    }
}
