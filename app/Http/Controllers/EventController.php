<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EventController extends Controller
{
    public function overview()
    {
        $events = Event::get();
        $mappedEvents = $events->map(function ($event) {
            return [
                'id' => $event->id,
                'title' => $event->title,
                'description' => $event->description,
                'start_date' => $event->start_date,
                'end_date' => $event->end_date,
                'start_time' => Carbon::parse($event->start_time)->format('H:i:s'),
                'end_time' => Carbon::parse($event->end_time)->format('H:i:s'),
            ];
        });
//        dd($mappedEvents);
        return Inertia::render('Calendar', [
            'events' => $mappedEvents
        ]);
    }

    public function add(Request $request)
    {
//        dd(Carbon::parse($request->startDate)->format('Y-m-d'));
        $request->validate([
            'title' => 'required',
            'startDate' => 'required'
        ]);

        $new = new Event();
        $new->title = $request->title;
        $new->start_date = Carbon::parse($request->startDate)->addDays(1)->format('Y-m-d');
        $new->end_date = $request->endDate !== null ?Carbon::parse($request->endDate)->format('Y-m-d'): null;
        $new->start_time = $request->startTime;
        $new->end_time = $request->endTime;
        if ($new->save()) {
            return back()
                ->with('success', 'Event created successfully!');
        }
        return back()
            ->with('error', 'Ops something wrong');
    }
    public function update(Request $request,$id)
    {
//        dd(Carbon::parse($request->startDate)->format('Y-m-d'));
        $request->validate([
            'title' => 'required',
            'startDate' => 'required'
        ]);

        $update = Event::find($id);
        $update->title = $request->title;
        $update->start_date = Carbon::parse($request->startDate)->format('Y-m-d');
        $update->end_date = $request->endDate !== null ?Carbon::parse($request->endDate)->format('Y-m-d'): null;
        $update->start_time = $request->startTime;
        $update->end_time = $request->endTime;
        if ($update->save()) {
            return back()
                ->with('success', 'Event updated successfully!');
        }
        return back()
            ->with('error', 'Ops something wrong');
    }
    function deleteEvent($id)
    {
        $event = Event::find($id)->delete();
        if ($event) {
            return back()
                ->with('success', 'Event deleted successfully!');
        }
        return back()
            ->with('error', 'Ops there is something wrong!');
    }
    public function getEvents(){
        $events = Event::get();
        $mappedEvents = $events->map(function ($event) {
            return [
                'id' => $event->id,
                'title' => $event->title,
                'description' => $event->description,
                'start_date' => $event->start_date,
                'end_date' => $event->end_date,
                'start_time' => Carbon::parse($event->start_time)->format('H:i:s'),
                'end_time' => Carbon::parse($event->end_time)->format('H:i:s'),
            ];
        });
        return response()->json(['events' => $mappedEvents]);
    }

}
