<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class CalendarController extends Controller
{
    public function overview(){

       return Inertia::render('Calendar');
    }
}