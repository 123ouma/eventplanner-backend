<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OB_Registration;
use App\Models\OB_Event;

class OB_AdminRegistrationApiController extends Controller
{
    public function index()
    {
        $registrations = OB_Registration::with(['user', 'event'])
            ->latest()
            ->get();

        return response()->json($registrations);
    }

    public function destroy($id)
    {
        $registration = OB_Registration::findOrFail($id);

        $event = OB_Event::find($registration->event_id);
        if ($event) {
            $event->increment('capacity');
        }

        $registration->delete();

        return response()->json([
            'message' => 'Registration deleted successfully'
        ]);
    }
}