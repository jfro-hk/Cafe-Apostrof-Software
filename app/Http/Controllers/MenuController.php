<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;

class MenuController extends Controller
{
    public function index()
    {
        $categories = Category::select('name','id')->get();
        $menus = Menu::all();
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
        $new->slug = $this->generateSlug($request->title, Category::class);
        $new->save();
    }

    private function generateSlug($title, $model)
    {
        // Generate slug from the title
        $slug = Str::slug($title);

        // Check if the generated slug already exists in the database
        $count = $model::where('slug', $slug)->count();

        // If the slug already exists, append a number to make it unique
        $suffix = $count > 0 ? '-' . ($count + 1) : '';

        // Keep appending suffix until the slug is unique
        while ($model::where('slug', $slug . $suffix)->exists()) {
            $suffix = '-' . Str::random(5); // You can customize the length of the random string
        }

        // Append the suffix to the slug
        $slug .= $suffix;

        return $slug;
    }

    public function createMenu(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'category' => 'required'
        ]);
//        $categoryId = null;
//        foreach ($request->category as $cate) {
//            if ($request->category != null) {
                $check = Category::where('id', $request->category)->first();
//                if ($check) {
                    $categoryId = $check->id;
//                }
//            }
//        }
//        dd($categoryId);
        $new = new Menu();
        $new->title = $request->title;
        $new->category_id = $categoryId;
        $new->slug = $this->generateSlug($request->title, Menu::class);
//        dd($categoryId);
        $new->save();
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

    public function update(Request $request,$id)
    {

        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required',
        ]);
//        dd($request->all());

//        $categoryId = null;
//        foreach ($request->category as $cate) {
            if ($request->category != null) {
                $check = Category::where('id', $request->category)->first();
//                if ($check) {
                    $categoryId = $check->id;
//                }
//            }
        }
        $menu = Menu::find($id);
        if (!$menu) {
            return abort(404);
        }

       $menu->title = $request->title;
       $menu->category_id = $categoryId;
       $menu->description = $request->description;
       $menu->save();

        return back()
            ->with('success', 'Menu deleted successfully!');
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
