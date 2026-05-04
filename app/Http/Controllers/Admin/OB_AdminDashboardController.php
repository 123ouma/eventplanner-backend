<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OB_Event;
use App\Models\OB_Category;
use App\Models\OB_Registration;

class OB_AdminDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'events'        => OB_Event::count(),
            'categories'    => OB_Category::count(),
            'registrations' => OB_Registration::count(),
        ];

     
        return view('admin.OB_dashboard', compact('stats'));
    }
}
