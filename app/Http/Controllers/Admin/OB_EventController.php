<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OB_Event;
use App\Models\OB_Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class OB_EventController extends Controller
{
    /* =======================
       LIST EVENTS
    ======================= */
    public function index()
    {
        $events = OB_Event::with('category')
            ->orderBy('id', 'desc')
            ->get();

        return view('admin.events.OB_index', compact('events'));
    }

    /* =======================
       CREATE FORM
    ======================= */
    public function create()
    {
        $categories = OB_Category::orderBy('name')->get();

        return view('admin.events.OB_create', compact('categories'));
    }

    /* =======================
       STORE EVENT
    ======================= */
    public function store(Request $request)
    {
        $request->validate([
            'title'        => 'required|string|max:255',
            'description'  => 'nullable|string',
            'start_date'   => 'required|date',
            'end_date'     => 'required|date|after_or_equal:start_date',
            'place'        => 'required|string|max:255',
            'capacity'     => 'required|integer|min:1',
            'category_id'  => 'required|exists:ob_categories,id',
            'is_free'      => 'required|boolean',
            'price'        => 'nullable|numeric|min:0',
            'image'        => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        /* Upload image */
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('events', 'public');
        }

        OB_Event::create([
            'title'       => $request->title,
            'description' => $request->description,
            'start_date'  => $request->start_date,
            'end_date'    => $request->end_date,
            'place'       => $request->place,
            'capacity'    => $request->capacity,
            'category_id' => $request->category_id,
            'is_free'     => $request->is_free,
            'price'       => $request->is_free ? 0 : $request->price,
            'image'       => $imagePath,
            'created_by'  => Auth::id(),
        ]);

        return redirect()
            ->route('admin.events.index')
            ->with('success', 'Event created successfully');
    }

    /* =======================
       SHOW EVENT
    ======================= */
    public function show($id)
    {
        $event = OB_Event::with(['category', 'user', 'registrations'])
            ->findOrFail($id);

        return view('admin.events.OB_show', compact('event'));
    }

    /* =======================
       EDIT FORM
    ======================= */
    public function edit($id)
    {
        $event = OB_Event::findOrFail($id);
        $categories = OB_Category::orderBy('name')->get();

        return view('admin.events.OB_edit', compact('event', 'categories'));
    }

    /* =======================
       UPDATE EVENT
    ======================= */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title'        => 'required|string|max:255',
            'description'  => 'nullable|string',
            'start_date'   => 'required|date',
            'end_date'     => 'required|date|after_or_equal:start_date',
            'place'        => 'required|string|max:255',
            'capacity'     => 'required|integer|min:1',
            'category_id'  => 'required|exists:ob_categories,id',
            'is_free'      => 'required|boolean',
            'price'        => 'nullable|numeric|min:0',
            'image'        => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $event = OB_Event::findOrFail($id);

        $imagePath = $event->image;

        if ($request->hasFile('image')) {
            if ($event->image && Storage::disk('public')->exists($event->image)) {
                Storage::disk('public')->delete($event->image);
            }

            $imagePath = $request->file('image')->store('events', 'public');
        }

        $event->update([
            'title'       => $request->title,
            'description' => $request->description,
            'start_date'  => $request->start_date,
            'end_date'    => $request->end_date,
            'place'       => $request->place,
            'capacity'    => $request->capacity,
            'category_id' => $request->category_id,
            'is_free'     => $request->is_free,
            'price'       => $request->is_free ? 0 : $request->price,
            'image'       => $imagePath,
        ]);

        return redirect()
            ->route('admin.events.index')
            ->with('success', 'Event updated successfully');
    }

    /* =======================
       DELETE EVENT
    ======================= */
    public function destroy($id)
    {
        $event = OB_Event::findOrFail($id);

        if ($event->image && Storage::disk('public')->exists($event->image)) {
            Storage::disk('public')->delete($event->image);
        }

        $event->delete();

        return redirect()
            ->route('admin.events.index')
            ->with('success', 'Event deleted successfully');
    }
}
