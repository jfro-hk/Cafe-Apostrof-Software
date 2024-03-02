<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Dishe;
use App\Models\Menu;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DisheController extends Controller
{
    public function index($slug)
    {
        $menu = Menu::where('slug', $slug)->first();
        $categories = Category::select('name', 'id')->where('menu_id',$menu->id)->get();

        $dishes = Dishe::select('dishes.id', 'dishes.menu_id', 'dishes.title', 'dishes.price', 'dishes.description',
            'categories.id as category_id',
            'categories.name as category_name')
            ->join('categories', 'dishes.category_id', '=', 'categories.id')
//            ->join('categories', 'menus.category_id', '=', 'categories.id')
            ->orderBy('dishes.created_at', 'DESC')
            ->where('dishes.menu_id', $menu->id)
            ->get();

        $mappedDishes = $dishes->map(function ($dish) {
            return [
                'title' => $dish->title,
                'price' => $dish->price,
                'description' => $dish->description,
                'menu_id' => $dish->menu_id,
                'category' => [
                    'id' => $dish->category_id,
                    'name' => $dish->category_name,
                ],
                'action' => $dish->id,
            ];
        });

//dd($dishes);

        return Inertia::render('Menu/View', [
            'categories' => $categories,
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
        $dish->category_id = $request->category;
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
        $dish->category_id = $request->category;
        $dish->menu_id = $request->menu_id;
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
