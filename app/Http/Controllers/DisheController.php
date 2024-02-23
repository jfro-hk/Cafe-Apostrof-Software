<?php

namespace App\Http\Controllers;

use App\Models\Dishe;
use App\Models\Menu;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DisheController extends Controller
{
    public function index($slug)
    {
        $menu = Menu::where('slug', $slug)->first();
        $dishes = Dishe::select('id','menu_id', 'title', 'price', 'description')->orderBy('created_at','DESC')->where('menu_id', $menu->id)->get();

        $mappedDishes = $dishes->map(function ($dish) {
            return [
                'title' => $dish->title,
                'price' => $dish->price,
                'description' => $dish->description,
                'action' => $dish->id,
            ];
        });

        return Inertia::render('Menu/View', [
            'menu' => $menu,
            'dishes' => $mappedDishes,
        ]);
    }

    public function add(Request $request, $menuId)
    {

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|integer',
        ]);
//        dd($menuId);
        $menu = Menu::find($request->menu_id);

        $dish = new Dishe();
//        dd($request->all());

        if (!$menu || !$dish) {
            return back()
                ->with('error', 'Ops something wrong!');
        }
        $dish->title = $request->title;
        $dish->price = $request->price;
        $dish->description = $request->description;
        $dish->menu_id = $request->menu_id;
        $dish->save();

        return back()
            ->with('success', 'Dish added successfully!');
//        return response()->json(['message' => 'Item added successfully'], 200);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|integer',
        ]);
        $menu = Menu::where('id', $request->menu_id)->first();
        $dish = Dishe::find($id);
//        dd($request->all());

        if (!$menu || !$dish) {
            return back()
                ->with('error', 'Ops something wrong!');
        }
        $dish->title = $request->title;
        $dish->price = $request->price;
        $dish->description = $request->description;
        $dish->menu_id = $request->menu_id;;
        $dish->save();


        return back()
            ->with('success', 'Dish updated successfully!');
    }

    public function delete($id)
    {

        $dishIds = $id;

        if (is_array($id)) {
            Dishe::whereIn('id', $dishIds)->delete();
        } else {
            Dishe::where('id', $dishIds)->delete();
        }
        return back()
            ->with('success', 'Dish deleted successfully!');
    }

}
