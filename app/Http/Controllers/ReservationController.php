<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function add(Request $request)
    {
//        dd($request->all());
        $request->validate([
            'fullname' => 'required|string',
            'email' => 'nullable|email',
            'number' => 'nullable|string',
            'date' => 'required|date',
            'time' => 'required',
            'antal' => 'required|integer|min:1',
        ]);
        $reservation = new Reservation();
//        $reservation = new Reservation();
        $reservation->fullname = $request->fullname;
        -
        $reservation->email = $request->email;
        $reservation->number = $request->number;
        $reservation->date = Carbon::parse($request->date)->timezone('Europe/Amsterdam')->format('Y-m-d');
        $reservation->time = $request->time;
        $reservation->antal = $request->antal;
        $reservation->description = $request->description;

        // Save the reservation
        if (
            $reservation->save()
        ) {
            $event = new Event();
            $event->title = $reservation->fullname;
            $event->start_date = $reservation->date;
            $event->start_time = $reservation->time;
            $event->description = $reservation->description;
//            $event->end_time = $request->endTime;
            $event->save();
            return back()
                ->with('success', 'Reservation added successfully!');
        }
        return back()
            ->with('error', 'Ops there is something wrong!');
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'fullname' => 'required|string',
            'email' => 'nullable|email',
            'number' => 'nullable|string',
            'date' => 'required|date',
            'time' => 'required',
            'antal' => 'required|integer|min:1',
        ]);
        $reservation = Reservation::find($id);
//        $reservation = new Reservation();
        $reservation->fullname = $request->fullname;
        -
        $reservation->email = $request->email;
        $reservation->number = $request->number;
        $reservation->date = Carbon::parse($request->date)->timezone('Europe/Amsterdam')->format('Y-m-d');
        $reservation->time = $request->time;
        $reservation->antal = $request->antal;
        $reservation->description = $request->description;

        // Save the reservation
        if (
            $reservation->save()
        ) {
//            $event = new Event();
//            $event->title = $reservation->fullname;
//            $event->start_date = $reservation->date;
//            $event->start_time = $reservation->time;
//            $event->description = $reservation->description;
//            $event->save();
//            $event->end_time = $request->endTime;
            return back()
                ->with('success', 'Reservation deleted successfully!');
        }
        return back()
            ->with('error', 'Ops there is something wrong!');
    }

    public function delete($id)
    {
        $reservation = Reservation::find($id);
        if ($reservation) {
            $reservation->delete();
            return back()
                ->with('success', 'Reservation deleted successfully!');

        }
        return back()
            ->with('error', 'Ops there is something wrong!');

    }
}
