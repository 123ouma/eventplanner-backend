<?php

namespace App\Http\Controllers;

use App\Models\OB_Event;
use App\Models\OB_Category;
use Illuminate\Http\Request;

class OB_EventController extends Controller
{
    /**
     * HOME — afficher tous les events (public, dynamique)
     */
    public function index(Request $request)
    {
        $query = OB_Event::query();

        //  Recherche par titre
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        //  Filtre par catégorie
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        //  Trier par date de début
        $events = $query
            ->orderBy('start_date', 'asc')
            ->paginate(6);

        // Liste des catégories pour le filtre
        $categories = OB_Category::all();

        return view('public.OB_events', compact('events', 'categories'));
    }

    /**
     * SHOW — afficher un event (public)
     */
    public function show($id)
    {
        $event = OB_Event::findOrFail($id);

        // autres events (exclure l'event courant)
        $otherEvents = OB_Event::where('id', '!=', $id)
            ->orderBy('start_date', 'asc')
            ->take(3)
            ->get();

        return view('public.OB_event_show', compact('event', 'otherEvents'));
    }
}
