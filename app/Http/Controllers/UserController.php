<?php
#test 
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function index()
    {
        if (Auth::user()->role !== 'regular_user') {
            abort(403, 'Unauthorized');
        }

        // Fetch data specific for regular users (e.g., events available to them)
        // $events = Event::all();

        return view('user.dashboard' /*, compact('events') */);
    }

   
}
