<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SuperAdminController extends Controller
{
    public function index()
    {
        // Check if user is super admin, else abort(403)
        if (Auth::user()->role !== 'super_admin') {
            abort(403, 'Unauthorized');
        }

        // Fetch any super admin specific data here, e.g. stats, users, events
        // $data = ...

        return view('admin.dashboard' /*, compact('data') */);
    }
}
