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
        $dishes = Dishe::select('id', 'title', 'price', 'description')->where('menu_id', $menu->id)->get();

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
        $menu = Menu::find($menuId);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|integer',
        ]);

        $dishe = new Dishe();
        $dishe->title = $request->title;
        $dishe->price = $request->price;
        $dishe->description = $request->description;
        $dishe->menu_id = $menuId;
        $dishe->save();
        return to_route('menu.view',$menu->slug)
            ->with('success', 'Dish added successfully!');
//        return response()->json(['message' => 'Item added successfully'], 200);
    }
    public function delete($id){

        $dishIds = $id;
//dd($id);
        if (is_array($id)){
             Dishe::whereIn('id', $dishIds)->delete();
        }else{
            Dishe::where('id', $dishIds)->delete();
        }
        return back()
            ->with('success', 'Dish deleted successfully!');
    }

}
