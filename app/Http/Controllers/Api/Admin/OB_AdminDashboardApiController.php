<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\OB_Event;
use App\Models\OB_Registration;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class OB_AdminDashboardApiController extends Controller
{
    public function index()
{
    $totalEvents = OB_Event::count();
    $totalRegistrations = OB_Registration::count();
    $totalUsers = User::count();

    $freeEvents = OB_Event::where('is_free', 1)->count();
    $paidEvents = OB_Event::where('is_free', 0)->count();

    // ✅ المهم هاذم
    $availableEvents = OB_Event::where('capacity', '>', 0)->count();
    $soldOutEvents = OB_Event::where('capacity', '<=', 0)->count();

    // ✅ bar chart data
    $registrationsByEvent = OB_Event::leftJoin('ob_registrations', 'ob_events.id', '=', 'ob_registrations.event_id')
        ->select(
            'ob_events.title',
            DB::raw('COUNT(ob_registrations.id) as registrations_count')
        )
        ->groupBy('ob_events.id', 'ob_events.title')
        ->orderByDesc('registrations_count')
        ->take(6)
        ->get();

    return response()->json([
        'total_events' => $totalEvents,
        'total_registrations' => $totalRegistrations,
        'total_users' => $totalUsers,
        'free_events' => $freeEvents,
        'paid_events' => $paidEvents,

        // ✅ زيدهم
        'available_events' => $availableEvents,
        'sold_out_events' => $soldOutEvents,
        'registrations_by_event' => $registrationsByEvent
    ]);
}
}