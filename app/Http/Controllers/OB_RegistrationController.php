<?php

namespace App\Http\Controllers;

use App\Models\OB_Registration;
use App\Models\OB_Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OB_RegistrationController extends Controller
{
    /**
     * Afficher la liste des inscriptions du user connecté
     */
    public function myRegistrations()
    {
        $registrations = OB_Registration::where('user_id', Auth::id())
            ->with('event.category')
            ->get();

        return view('user.OB_my_registrations', compact('registrations'));
    }

    /**
     * Enregistrer une inscription
     */
    public function store(Request $request)
    {
        $request->validate([
            'event_id' => 'required|exists:ob_events,id',
        ]);

        $event = OB_Event::findOrFail($request->event_id);

        // Vérifier les places disponibles
        if ($event->capacity <= 0) {
            return back()->with('error', 'Plus de places disponibles');
        }

        // Vérifier inscription unique
        $alreadyRegistered = OB_Registration::where('user_id', Auth::id())
            ->where('event_id', $event->id)
            ->exists();

        if ($alreadyRegistered) {
            return back()->with('error', 'Vous êtes déjà inscrit à cet événement');
        }

        // Créer l'inscription
        OB_Registration::create([
            'user_id'  => Auth::id(),
            'event_id' => $event->id,
        ]);

        // Mettre à jour la capacité
        $event->decrement('capacity');

        return redirect()
            ->route('registrations.my')
            ->with('success', 'Inscription effectuée avec succès');
    }

    /**
     * Désinscription (optionnelle)
     */
    public function destroy($id)
    {
        $registration = OB_Registration::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $event = $registration->event;

        // Supprimer inscription
        $registration->delete();

        // Restituer la place
        $event->increment('capacity');

        return back()->with('success', 'Désinscription effectuée');
    }
}
