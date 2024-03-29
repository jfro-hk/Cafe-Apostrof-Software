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
        $reservations = Reservation::select('id','fullname','date','time','antal','created_at','description','table')->orderBy('date','DESC')->get();
        $mappedReservation = $reservations->map(function ($reservation) {
            return [
//                'id' => $reservation->id,
                'fulde navn' => $reservation->fullname,
                'description' => $reservation->description,
                'dato' => Carbon::parse($reservation->date)->format('Y-m-d'),
                'tid' => $reservation->time,
                'antal' => $reservation->antal,
                'oprettet på' => Carbon::parse($reservation->created_at)->format('Y/m/d'),
                'bord' => $reservation->table,
                'action' => $reservation->id,
            ];
        });
        $events = Event::select('id','title','start_date','end_date','start_time','end_time')->orderBy('start_date','DESC')->get();
        $mappedEvents = $events->map(function ($event) {
            return [
                'titel' => $event->title,
//                'description' => $event->description,
                'dato' => Carbon::parse($event->start_date)->format('M d'),
                'action' => $event->id,
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
            'post_route' => route('reservation.add'),
        ]);
    }
}
