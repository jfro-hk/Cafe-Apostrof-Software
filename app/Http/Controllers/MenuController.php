<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;

class MenuController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return Inertia::render('Menu/OverView', [
            'categories' => $categories
        ]);
    }
    function addCategory(Request $request)
    {
        $request->validate([
            'title' => 'required'
        ]);
        $new = new Category();
        $new->name = $request->title;

        // Generate slug from the title
        $slug = Str::slug($request->title);

        // Check if the generated slug already exists in the database
        $count = Category::where('slug', $slug)->count();

        // If the slug already exists, append a number to make it unique
        if ($count > 0) {
            $slug = $slug . '-' . ($count + 1);
        }

        $new->slug = $slug;
        $new->save();
    }
}
