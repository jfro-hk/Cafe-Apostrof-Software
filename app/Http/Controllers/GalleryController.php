<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;
use Inertia\Inertia;

class GalleryController extends Controller
{
 public function index(){
     $gallery = Gallery::get();
     $mappedGallery = $gallery->map(function ($dish) {
         return [
             'title' => $dish->title,
             'media' => $dish->price,
             'description' => $dish->description,
             'action' => $dish->id,
         ];
     });
     return Inertia::render('Gallery/Overview',[
         'gallery' => $mappedGallery
     ]);
 }
}
