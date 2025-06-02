<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EventController extends Controller
{
    public function create()
    {
        // Logic to show the booking form
        return view('user.book');
    }

  
}
