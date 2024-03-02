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
use Illuminate\Validation\Rule;

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
        ]);
        $settings = Setting::first();
        $totalTablesSum = Reservation::sum('antal');
        $totalReservations = Reservation::count();
        if ($totalTablesSum < $settings->total_tables) {
            // Create a new Reservation instance
            $reservation = new Reservation();
            $reservation->fullname = $request->fullname;
            $reservation->email = $request->email;
            $reservation->number = $request->number;
            $reservation->date = Carbon::parse($request->date)->format('Y-m-d');
            $reservation->time = $request->time;
            $reservation->antal = $request->antal;
            $reservation->description = $request->description;

            // Save the reservation
            if ($reservation->save()) {
                $event = new Event();
                $event->title = $reservation->fullname;
                $event->start_date = $reservation->date;
                $event->start_time = $reservation->time;
                $event->description = $reservation->description;
                $event->save();
//            $event->end_time = $request->endTime;
            }
            return response()->json(200, 201);

        } else {
            return response()->json(204, 201);
        }
    }

    public function getGallery()
    {
        $gallery = Gallery::get();

        $mappedGallery = $gallery->map(function ($media) {
            return [
                'title' => $media->title,
                'media' => $media->media,
                'description' => $media->description,
                'action' => $media->id,
            ];
        });
        return response()->json([$mappedGallery], 201);
    }

    public function getMenu()
    {
        // Fetch all categories
// Fetch categories with related menus and dishes using join
        // Fetch categories with related menus and dishes using join
        $categories = Category::select('categories.id as category_id', 'dishes.price', 'categories.name', 'menus.created_at', 'menus.id as menu_id', 'menus.title as menu_title', 'menus.description as menu_description', 'dishes.title as dish_title', 'dishes.description as dish_description')
            ->join('menus', 'categories.id', '=', 'menus.category_id')
            ->join('dishes', 'menus.id', '=', 'dishes.menu_id')
            ->orderBy('menus.created_at', 'DESC')
            ->get()
            ->toArray();


        // Fetch all menus
        $menus = Menu::select('created_at', 'id', 'title', 'description', 'category_id', 'slug')
            ->orderBy('created_at', 'DESC')
            ->get();

        // Fetch all dishes
        $dishes = Dishe::select('created_at', 'id', 'title', 'description', 'menu_id')
            ->orderBy('created_at', 'DESC')
            ->get();

        // Organize dishes by menu and category
        $dishesByMenuAndCategory = [];

        foreach ($menus as $menu) {
            $menuId = $menu->id;
            $categoryId = $menu->category_id;

            // Initialize dishes array for the current category if not exists
            if (!isset($dishesByMenuAndCategory[$categoryId][$menuId])) {
                $dishesByMenuAndCategory['category'][$categoryId] = [];
            }

            // Find dishes related to the current menu
            $menuDishes = $dishes->filter(function ($dish) use ($menuId) {
                return $dish->menu_id == $menuId;
            });

            // Add menu dishes to the corresponding category and menu
            $dishesByMenuAndCategory['category'][$categoryId] = $menuDishes->toArray();
        }

        return response()->json($categories, 201);
    }

    public function getCategories()
    {
        $categories = Category::select('name', 'id')->get();

        return response()->json($categories, 201);
    }

    public function getSettings()
    {
        $settings = Setting::first();
        $opening_times = [];

        // Check if $settings->opening_times is not empty
        if (!empty($settings->opening_times)) {
            // Split the string into an array using the delimiter (assuming it's comma)
            $opening_times = explode(',', $settings->opening_times);
        }

        // Assuming you want to include the opening_times array in the response
        $settings->opening_times = $opening_times;

        return response()->json($settings, 201);
    }

}
