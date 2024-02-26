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
                'start' => $event->start_date,
                'end' => $event->end_date,
            ];
        });
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
    public function getEvents(){
        $events = Event::select('id','title','description','start_date','end_date')->get();
        return response()->json(['events' => $events]);
    }
}
