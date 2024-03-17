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
        $imageList = Dishe::select('dishes.id', 'dishes.menu_id', 'dishes.img')
            ->where('dishes.menu_id', $menu->id)
            ->whereNotNull('dishes.img')
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
            'imageList' => $imageList,
        ]);
    }
    public function addImage(Request $request, $menuId)
    {
        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Adjusted validation rules for image files
        ]);

        $menu = Menu::find($menuId);

        if (!$menu) {
            return back()->with('error', 'Menu not found!');
        }

        // Check if the dish with the specified menuId already exists
        $dish = Dishe::where('menu_id', $menuId)->first();

        // If the dish already exists, update the image
        if ($dish) {
            if ($request->hasFile('file')) {
                $imageName = $request->file('file')->getClientOriginalName();
                $dish->img = '/images/' . $imageName = time() . '.' . $imageName;
                $request->file('file')->move(public_path('../public/images'), $imageName);
                $dish->save();
                return back()->with('success', 'Image updated successfully!');
            } else {
                return back()->with('error', 'No image provided!');
            }
        } else {
            // If the dish doesn't exist, create a new one with the provided image
            if ($request->hasFile('file')) {
                $imageName = $request->file('file')->getClientOriginalName();
                $dish = new Dishe();
                $dish->img = '/images/' . $imageName = time() . '.' . $imageName;
                $request->file('file')->move(public_path('../public/images'), $imageName);
                $dish->menu_id = $menuId;
                $dish->save();
                return back()->with('success', 'Image added successfully!');
            } else {
                return back()->with('error', 'No image provided!');
            }
        }
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
    public function changeMode($menuId, $mode)
    {
//        dd($mode);
        // Validate the mode value
        if ($mode !== 'img' && $mode !== 'dishes') {
            return back()->with('error', 'Invalid mode value!');
        }

        // Find the menu by its ID
        $menu = Menu::find($menuId);

        // Check if the menu exists
        if (!$menu) {
            return back()->with('error', 'Menu not found!');
        }

        // Update the mode column
        $menu->mode = $mode;
        $menu->save();

        return back()->with('success', 'Mode updated successfully!');
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
