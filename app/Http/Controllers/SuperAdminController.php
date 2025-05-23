<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class SuperAdminController extends Controller
{
    public function index()
    {
        // Check if user is super admin, else abort(403)
        if (Auth::user()->role !== 'super_admin') {
            abort(403, 'Unauthorized');
        }

       $totalUsers = User::count();            // Total users count
        $users = User::paginate(15);            // Paginated users list

        return view('admin.dashboard', compact('totalUsers', 'users'));
    }
}
