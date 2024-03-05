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
        $totalMenu = Menu::count();
        return Inertia::render('Menu/OverView', [
            'categories' => $categories,
            'menus' => $menus,
            'totalMenu' => $totalMenu,
        ]);
    }

    function addCategory(Request $request, $id)
    {
//        dd($request->all());
//        $request->validate([
//            'title' => 'required'
//        ]);
        $new = new Category();
        $new->name = $request->title;
        $new->menu_id = $id;
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
        ]);

        $new = new Menu();
        $new->title = $request->title;
        $new->slug = Setting::generateSlug($request->title, Menu::class);


        $new->save();
        if ($request->dish['title'] !== null && $request->dish['price'] !== null) {
        $category = new Category();
        $category->name = $request->dish['category'];
        $category->menu_id = $new->id;
        $category->slug = Setting::generateSlug($request->title, Category::class);
        $category->save();
        $this->addDish($new->id, $category->id, $request->dish);
        }

        return to_route('menu')
            ->with('success', 'Menu created successfully!');
//       }
//        return to_route('menu')
//            ->with('success', 'Menu created successfully!');
    }

    public function addDish($menuId, $categoryId, $data)
    {

//        $request->validate([
//            'title' => 'required|string|max:255',
//            'description' => 'nullable|string',
//            'price' => 'required|integer',
//        ]);
//        dd($menuId);
        $menu = Menu::find($menuId);

        $dish = new Dishe();
//        dd($request->all());

        if (!$menu || !$dish) {
            return back()
                ->with('error', 'Ops something wrong!');
        }
        $dish->title = $data['title'];
        $dish->price = $data['price'];
        $dish->description = $data['description'];
        $dish->menu_id = $menuId;
        $dish->category_id = $categoryId;
        $dish->save();

        return back()
            ->with('success', 'Dish added successfully!');
//        return response()->json(['message' => 'Item added successfully'], 200);
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
