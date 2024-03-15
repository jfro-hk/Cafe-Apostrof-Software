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

        $dishes = Dishe::select('dishes.id', 'dishes.menu_id', 'dishes.title', 'dishes.price', 'dishes.extra_note','dishes.description',
            'categories.id as category_id',
            'categories.name as category_name')
            ->join('categories', 'dishes.category_id', '=', 'categories.id')
//            ->join('categories', 'menus.category_id', '=', 'categories.id')
            ->orderBy('categories.name', 'DESC')
            ->where('dishes.menu_id', $menu->id)
            ->get();

        $mappedDishes = $dishes->map(function ($dish) {
            return [
                'title' => $dish->title,
                'price' => $dish->price,
                'description' => $dish->description,
                'extra_note' => $dish->extra_note?$dish->extra_note:'-',
//                'menu_id' => $dish->menu_id,
                'category' => [
                    'id' => $dish->category_id,
                    'name' => $dish->category_name,
                ],
                'action' => $dish->id,
            ];
        });

//dd($dishes);
        $totalDishes = Dishe::where('menu_id', $menu->id)
            ->count();
        return Inertia::render('Menu/View', [
            'categories' => $categories,
            'menu' => $menu,
            'dishes' => $mappedDishes,
            'totalDishes' => $totalDishes,
        ]);
    }
    public function addImage(Request $request, $menuId)
    {
//dd($request->all());
        $request->validate([
            'file' => 'required|file',
        ]);
//        dd($menuId);
        $menu = Menu::find($menuId);

        $dish = new Dishe();
//        dd($request->all());

        if (!$menu || !$dish) {
            return back()
                ->with('error', 'Ops something wrong!');
        }
        $imageName = $request->file('file')->getClientOriginalName();

        if ($request->hasFile('file')) {
            $dish->img = '/images/'.$imageName = time() . '.' . $imageName;
            $request->file->move(public_path('../public/images'), $imageName);
        }
        $dish->menu_id = $menuId;
        $dish->save();

        return back()
            ->with('success', 'The list added successfully!');
//        return response()->json(['message' => 'Item added successfully'], 200);
    }
    public function updateImage(Request $request, $menuId)
    {
        //dd($request->all());
        $request->validate([
            'file' => 'required|file',
        ]);
//        dd($menuId);
        $menu = Menu::find($menuId);

        $dish = new Dishe();
//        dd($request->all());
        if (!$menu || !$dish) {
            return back()
                ->with('error', 'Ops something wrong!');
        }
        $imageName = $request->file('file')->getClientOriginalName();

        if ($request->hasFile('file')) {
            $dish->img = '/images/'.$imageName = time() . '.' . $imageName;
            $request->file->move(public_path('../public/images'), $imageName);
        }
        $dish->menu_id = $menuId;
        $dish->save();

        return back()
            ->with('success', 'The list added successfully!');
//        return response()->json(['message' => 'Item added successfully'], 200);
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
        $dish->extra_note = $request->extra_note;
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
        $dish->extra_note = $request->extra_note;
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
