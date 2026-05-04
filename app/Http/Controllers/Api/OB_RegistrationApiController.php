<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OB_Registration;
use App\Models\OB_Event;

class OB_RegistrationApiController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'event_id' => 'required|exists:ob_events,id',
        ]);

        $exists = OB_Registration::where('user_id', $data['user_id'])
            ->where('event_id', $data['event_id'])
            ->exists();

        if ($exists) {
            return response()->json([
                'message' => 'You already reserved this event'
            ], 400);
        }

        $event = OB_Event::findOrFail($data['event_id']);

        if ($event->capacity <= 0) {
            return response()->json([
                'message' => 'No places available for this event'
            ], 400);
        }

        $registration = OB_Registration::create([
            'user_id' => $data['user_id'],
            'event_id' => $data['event_id'],
        ]);

        $event->decrement('capacity');

        return response()->json([
            'message' => 'Reservation successful',
            'registration' => $registration,
            'remaining_capacity' => $event->fresh()->capacity
        ], 201);
    }

    public function myRegistrations($userId)
    {
        $registrations = OB_Registration::with('event')
            ->where('user_id', $userId)
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
            'message' => 'Reservation cancelled successfully'
        ]);
    }
}