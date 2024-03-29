<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Dishe;
use App\Models\Event;
use App\Models\Gallery;
use App\Models\Menu;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Models\Reservation;

class ApiController extends Controller
{
    public function add(Request $request)
    {
//        return $request->all();
        // Validate the incoming request data
        $request->validate([
            'fullname' => 'required|string',
            'email' => 'nullable|email',
            'number' => 'nullable|string',
            'date' => 'required|date',
            'time' => 'required',
            'antal' => 'required|integer|min:1',
            'table' => 'required',
        ]);
        $settings = Setting::first();

        $totalTablesSum = Reservation::whereDate('date', Carbon::parse($request->date)->timezone('Europe/Amsterdam')->format('Y-m-d'))->sum('antal');
        $checkOperation = $totalTablesSum + $request->antal;
//        return $request->table['type'];
        if ($checkOperation <= $settings->total_tables) {

            // Create a new Reservation instance
            $reservation = new Reservation();
            $reservation->fullname = $request->fullname;
            -
            $reservation->email = $request->email;
            $reservation->number = $request->number;
            $reservation->date = Carbon::parse($request->date)->timezone('Europe/Amsterdam')->format('Y-m-d');
            $reservation->time = $request->time;
            $reservation->end_time = Carbon::parse($request->time)->addHours(3)->timezone('Europe/Amsterdam')->format('H:i:s');
            $reservation->description = $request->description;
            $reservation->antal = $request->antal;
            $reservation->table = $request->table['type'];

            // Save the reservation
            if ($reservation->save()) {
                $event = new Event();
                $event->title = $reservation->fullname;
                $event->start_date = $reservation->date;
                $event->start_time = $reservation->time;
                $event->description = $reservation->description;
                $event->save();
//            $event->end_time = $request->endTime;
                return response()->json(200, 201);
            }
            return response()->json(['message', 'Ops something wrong']);
        } else {
            return response()->json(204, 201);
        }
    }

    public function getGallery()
    {
        $gallery = Gallery::select('title', 'description', 'media')->get();

        return response()->json($gallery, 201);
    }

    public function getMenuListImage($menuId)
    {
        $imageList = Dishe::select('dishes.id', 'dishes.menu_id', 'dishes.img')
            ->where('dishes.menu_id', $menuId)
            ->whereNotNull('dishes.img')
            ->get();
    }

    public function getMenu()
    {
        // Fetch all categories
        $categories = Category::select('categories.id as category_id', 'dishes.price', 'categories.name', 'menus.created_at', 'menus.id as menu_id', 'menus.title as menu_title', 'menus.description as menu_description', 'dishes.title as dish_title', 'dishes.description as dish_description')
            ->join('menus', 'categories.id', '=', 'menus.category_id')
            ->join('dishes', 'menus.id', '=', 'dishes.menu_id')
            ->orderBy('menus.created_at', 'DESC')
            ->get()
            ->toArray();


        // Fetch all menus
        $menus = Menu::select('created_at', 'id', 'title', 'description', 'category_id', 'slug', 'mode', 'img')
            ->orderBy('created_at', 'ASC')
            ->get();

        return response()->json($menus, 201);
    }

    public function getDishes()
    {
        $dishes = Dishe::select('dishes.id', 'dishes.menu_id', 'dishes.title', 'dishes.price', 'dishes.description',
            'categories.id as category_id',
            'categories.name as category_name')
            ->join('categories', 'dishes.category_id', '=', 'categories.id')
//            ->join('categories', 'menus.category_id', '=', 'categories.id')
            ->orderBy('dishes.created_at', 'ASC')
            ->get();

        return response()->json($dishes, 201);
    }

    public function getCategories()
    {
        $categories = Category::select('menu_id', 'name', 'id')->orderBy('created_at', 'ASC')->get();

        return response()->json($categories, 201);
    }

    public function getTables($date, $time)
    {
        $settings = Setting::first();
        $formattedTime = Carbon::parse($time)->format('H:i:s');
        $settingsTables = unserialize($settings->tables);
        $reservations = Reservation::where('date', $date)->get();
        foreach ($settingsTables as &$table) {
            $reservedCount = $reservations->where('table', $table['type'])
                ->where(function ($query) use ($formattedTime) {
//                    dd($query->time <= $formattedTime);
                    if ($query->time > $formattedTime || $query->end_time < $formattedTime) {
//                        dd('nice');
                        return false;
                    }else{
                        // disable the time
                        return true;
                    }
//                    $query->where('time', '==', $formattedTime); // Reservation starts after provided time
//                    ->orWhere('end_time', '=>', $formattedTime); // Reservation ends before provided time
                })
                ->count();

            if ($reservedCount > 0) {
                $table['total'] -= 1;
            }
        }
        return response()->json($settingsTables, 201);
    }


    public function getSettings()
    {
        $settings = Setting::first();
        $opening_times = [];
        $tables = [];

        // Check if $settings->opening_times is not empty
        if (!empty($settings->opening_times)) {
            // Split the string into an array using the delimiter (assuming it's comma)
            $opening_times = explode(',', $settings->opening_times);
        }

        // Assuming you want to include the opening_times array in the response
        $settings->opening_times = $opening_times;
        if (!empty($settings->tables)) {
            $tables = unserialize($settings->tables);
        }
        $settingsTables = unserialize($settings->tables);
        $reservations = Reservation::all();

        foreach ($settingsTables as &$table) {
            // Check if the table type exists in the reservations
            $reservedCount = $reservations->where('table', $table['type'])->count();
            if ($reservedCount > 0) {
                // Decrease one from the total
                $table['total'] -= 1;
            }
        }
        $settings->tables = $settingsTables;

        return response()->json($settings, 201);
    }

}
