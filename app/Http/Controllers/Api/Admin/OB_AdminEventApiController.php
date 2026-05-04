<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\OB_Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class OB_AdminEventApiController extends Controller
{
    // LISTE ADMIN
    public function index()
    {
        $events = OB_Event::orderBy('start_date', 'asc')->get();

        $events->transform(function ($event) {
            $event->location = $event->place;
            return $event;
        });

        return response()->json($events);
    }

    // DETAIL EVENT ADMIN
    public function show($id)
    {
        $event = OB_Event::findOrFail($id);
        $event->location = $event->place;

        return response()->json([
            'event' => $event
        ]);
    }

    // CREATE EVENT
  public function store(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'start_date' => 'required|date',
        'end_date' => 'required|date|after_or_equal:start_date',
        'place' => 'required|string|max:255',
        'capacity' => 'required|integer|min:1',
        'category_id' => 'required|exists:ob_categories,id',
        'is_free' => 'required|boolean',
        'price' => 'nullable|numeric|min:0',
        'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
    ]);

    $imagePath = null;

    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('events', 'public');
    }

    $event = OB_Event::create([
        'title' => $request->title,
        'description' => $request->description,
        'start_date' => $request->start_date,
        'end_date' => $request->end_date,
        'place' => $request->place,
        'capacity' => $request->capacity,
        'category_id' => $request->category_id,
        'is_free' => $request->is_free,
        'price' => $request->is_free ? 0 : $request->price,
        'image' => $imagePath,
      'created_by' => Auth::id() ?? 1,
    ]);

    return response()->json([
        'message' => 'Event created successfully',
        'event' => $event
    ], 201);
}
    // UPDATE EVENT
    public function update(Request $request, $id)
    {
        $event = OB_Event::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required',
            'end_date' => 'required',
            'location' => 'nullable|string|max:255',
            'place' => 'nullable|string|max:255',
            'price' => 'required|numeric|min:0',
            'capacity' => 'required|integer|min:1',
            'category_id' => 'nullable|integer',
            'created_by' => 'nullable|integer',
            'is_free' => 'nullable',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $validated['place'] = $request->input('location') ?? $request->input('place');

        if (!$validated['place']) {
            return response()->json([
                'message' => 'The location field is required.'
            ], 422);
        }

        unset($validated['location']);

        if ($request->hasFile('image')) {
            if ($event->image && Storage::disk('public')->exists($event->image)) {
                Storage::disk('public')->delete($event->image);
            }

            $validated['image'] = $request->file('image')->store('events', 'public');
        }

        $event->update($validated);
        $event->location = $event->place;

        return response()->json([
            'message' => 'Event updated successfully',
            'event' => $event
        ]);
    }

    // DELETE EVENT
    public function destroy($id)
    {
        $event = OB_Event::findOrFail($id);

        if ($event->image && Storage::disk('public')->exists($event->image)) {
            Storage::disk('public')->delete($event->image);
        }

        $event->delete();

        return response()->json([
            'message' => 'Event deleted successfully'
        ]);
    }
}