<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Loads the admin dashboard
     */
    public function dashboard(): View
    {
        return view('admin.dashboard');
    }
}
