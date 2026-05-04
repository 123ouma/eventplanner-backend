<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\OB_Event;

class OB_EventApiController extends Controller
{
    // GET ALL EVENTS
    public function index()
    {
        return OB_Event::orderBy('start_date', 'asc')->get();
    }

    // GET ONE EVENT + RELATED
    public function show($id)
    {
        $event = OB_Event::findOrFail($id);

        $related = OB_Event::where('id', '!=', $id)
            ->orderBy('start_date', 'asc')
            ->take(3)
            ->get();

        return response()->json([
            'event' => $event,
            'related' => $related
        ]);
    }
}