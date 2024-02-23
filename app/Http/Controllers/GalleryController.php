<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class GalleryController extends Controller
{
    public function index()
    {
//        dd('dd');
        $gallery = Gallery::get();
        $mappedGallery = $gallery->map(function ($media) {
            return [
                'title' => $media->title,
                'media' => $media->media,
                'description' => $media->description,
                'action' => $media->id,
            ];
        });
        return Inertia::render('Gallery/Overview', [
            'gallery' => $mappedGallery
        ]);
    }

    public function add(Request $request)
    {
//        dd($request->all());
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'file' => 'required|file',
        ]);
        $imageName = $request->file('file')->getClientOriginalName();

        $new = new Gallery();
        $new->title = $request->title;
        $new->description = $request->description;
        $new->slug = Setting::generateSlug($request->title, Gallery::class);
        if ($request->hasFile('file')) {
            $new->media = '/gallery/'.$imageName = time() . '.' . $imageName;
            $request->file->move(public_path('../public/gallery'), $imageName);
        }

        if ($new->save()) {
            return back()
                ->with('success', 'Menu added successfully!');
        }
        return back()
            ->with('error', 'Ops there is something wrong!');

    }

    public function update(Request $request, $id)
    {
        $gallery = Gallery::find($id);
        if (!$gallery) {
            return back()->with('error', 'Gallery item not found!');
        }

        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'file' => 'nullable|file', // Allow file to be nullable for update
        ]);

        // Update title and description
        $gallery->title = $request->title;
        $gallery->description = $request->description;

        // Handle file update if provided
        if ($request->hasFile('file')) {
            // Delete the existing image file from storage
            if (file_exists(public_path($gallery->media))) {
                unlink(public_path($gallery->media));
            }

            // Upload and store the new image file
            $imageName = $request->file('file')->getClientOriginalName();
            $gallery->media = '/gallery/' . time() . '.' . $imageName;
            $request->file->move(public_path('../public/gallery'), $imageName);
        }

        if ($gallery->save()) {
            return back()->with('success', 'Gallery item updated successfully!');
        } else {
            return back()->with('error', 'Failed to update gallery item!');
        }
    }

    public function delete($id)
    {
        $gallery = Gallery::find($id);
        if (!$gallery) {
            return back()->with('error', 'Gallery item not found!');
        }

        if (file_exists('../public/'.$gallery->media)){
            unlink('../public/'.$gallery->media);
        }

        $deleted = $gallery->delete();

        if ($deleted) {
            return back()->with('success', 'Gallery item deleted successfully!');
        } else {
            return back()->with('error', 'Failed to delete gallery item!');
        }
    }

}
