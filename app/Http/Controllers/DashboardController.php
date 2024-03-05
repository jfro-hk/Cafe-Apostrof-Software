<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Gallery;
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
                'fulde navn' => $reservation->fullname,
                'dato' => Carbon::parse($reservation->date)->format('M d'),
                'tid' => $reservation->time,
                'antal' => $reservation->antal,
                'oprettet på' => Carbon::parse($reservation->date)->format('Y/m/d'),
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

        $date = Carbon::today();
        $todayReservations = Reservation::whereDate('date', $date)->get();

        $totalReservations = $todayReservations->count();
        $totalGallery = Gallery::count();
        return Inertia::render('Dashboard', [
            'events' => $mappedEvents,
            'reservations' => $mappedReservation,
            'totalTodayReservations' => $totalReservations,
            'totalGallery' => $totalGallery,
        ]);
    }
}
