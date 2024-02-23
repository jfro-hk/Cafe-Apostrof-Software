<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Setting extends Model
{
    use HasFactory;
    static function generateSlug($title, $model)
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
}
