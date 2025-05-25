<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventImage;
use Illuminate\Http\Request;

class BasketController extends Controller
{
    public function add(Event $event)
    {
        $basket = session()->get('basket', []);
        if (!in_array($event->id, $basket)) {
            $basket[] = $event->id;
            session(['basket' => $basket]);
        }

        return redirect()->back()->with('success', 'Event added to basket.');
    }

    public function view()
    {
        $eventIds = session('basket', []);
        $events = Event::whereIn('id', $eventIds)->with('headImage')->get();
        $total = $events->sum('price');

        return view('basket.view', compact('events', 'total'));
    }

    public function checkout()
    {
        $user = auth()->user();
        $eventIds = session('basket', []);
        $events = Event::whereIn('id', $eventIds)->get();

        foreach ($events as $event) {
            $alreadyJoined = $event->participants()->where('user_id', $user->id)->exists();
            $isAvailable = $event->status === 'planned' && $event->participants()->count() < $event->capacity;

            if ($isAvailable && !$alreadyJoined) {
                $event->participants()->attach($user->id);
            }
        }

        session()->forget('basket');
        return redirect()->route('events.my')->with('success', 'Payment successful. Events joined.');
    }

    public function remove(Event $event)
    {
        $basket = session('basket', []);
        session(['basket' => array_diff($basket, [$event->id])]);

        return redirect()->back()->with('success', 'Event removed from basket.');
    }
}
