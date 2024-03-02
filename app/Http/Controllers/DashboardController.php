<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Reservation;
use Carbon\Carbon;
use Inertia\Inertia;

class DashboardController extends Controller
{
//    public function __construct()
//    {
//        $this->middleware('auth');
//    }

    public function index()
    {
        $reservations = Reservation::select('id','fullname','date','time','antal','created_at')->get();
        $mappedReservation = $reservations->map(function ($reservation) {
            return [
                'id' => $reservation->id,
                'fullname' => $reservation->fullname,
                'date' => Carbon::parse($reservation->date)->format('M d'),
                'time' => $reservation->time,
                'antal' => $reservation->antal,
                'created_at' => Carbon::parse($reservation->date)->format('Y/m/d'),
            ];
        });
        $events = Event::select('id','title','start_date','end_date','start_time','end_time')->orderBy('created_at','DESC')->get();
        $mappedEvents = $events->map(function ($event) {
            return [
                'id' => $event->id,
                'title' => $event->title,
//                'description' => $event->description,
                'date' => Carbon::parse($event->start_date)->format('M d'),
//                'end' => $event->end_date,
            ];
        });
        return Inertia::render('Dashboard', [
            'events' => $mappedEvents,
            'reservations' => $mappedReservation,
        ]);
    }
}
