<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Dishe;
use App\Models\Menu;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;

class MenuController extends Controller
{
    public function index()
    {
        $categories = Category::select('name', 'id')->get();
        $menus = Menu::select('created_at', 'id', 'title', 'description', 'category_id', 'slug')->orderBy('created_at', 'DESC')->get();
        return Inertia::render('Menu/OverView', [
            'categories' => $categories,
            'menus' => $menus
        ]);
    }

    function addCategory(Request $request)
    {
        $request->validate([
            'title' => 'required'
        ]);
        $new = new Category();
        $new->name = $request->title;
        $new->slug = Setting::generateSlug($request->title, Category::class);
        $new->save();
    }

    function deleteCategory($id)
    {
        $category = Category::find($id)->delete();
        if ($category) {
            return back()
                ->with('success', 'Category deleted successfully!');
        }
        return back()
            ->with('error', 'Ops there is something wrong!');
    }
    public function createMenu(Request $request)
    {
//        dd($request->all());

        $request->validate([
            'title' => 'required',
            'category' => 'required'
        ]);
//        $categoryId = null;
//        foreach ($request->category as $cate) {
//            if ($request->category != null) {

//        $check = Category::where('id', $request->category)->first();
//                if ($check) {
        $categoryId = $request->category['id']; //$check->id;
//                }
//            }
//        }
        $new = new Menu();
        $new->title = $request->title;
        $new->category_id = $categoryId;
        $new->slug = Setting::generateSlug($request->title, Menu::class);

        if ($request->dish['title']
            !== null && $request->dish['price']
            !== null && $request->dish['description'] !== null) {
            $dish = new Dishe();
            $dish->title = $request->dish['title'];
            $dish->price = $request->dish['price'];
            $dish->description = $request->dish['description'];
            $new->save();
            $dish->menu_id = $new->id;
            $dish->save();
        } else {
            $new->save();
            return to_route('menu')
                ->with('success', 'Menu created successfully!');
        }
        return to_route('menu')
            ->with('success', 'Menu created successfully!');
    }

    public function edit($id)
    {
        $menu = Menu::find($id);
        if ($menu) {
            return $menu;
        }
        return abort(404);
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required',
        ]);
        $categoryId = $request->category;
//        dd($request->category);
        if (is_array($request->category) && isset($request->category['id'])) {
            $categoryId = $request->category['id'];
        }

        $menu = Menu::find($id);
        if (!$menu) {
            return abort(404);
        }
        if ($categoryId != 0) {

            $menu->title = $request->title;
            $menu->category_id = $categoryId;
            $menu->description = $request->description;
            $menu->save();
        }
        return back()
            ->with('success', 'Menu updated successfully!');
    }

    public function delete($id)
    {
        $menu = Menu::find($id)->delete();
        if ($menu) {
            return back()
                ->with('success', 'Menu deleted successfully!');
        }
        return back()
            ->with('error', 'Ops there is something wrong!');
    }
}
