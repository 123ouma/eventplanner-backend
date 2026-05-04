<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OB_Registration;

class OB_RegistrationController extends Controller
{
    // LIST
 public function index()
{
    $registrations = OB_Registration::with(['event', 'user'])
        ->orderBy('id', 'desc')
        ->get();

    return view('admin.registrations.OB_index', compact('registrations'));
}

    // SHOW
    public function show($id)
    {
        $registration = OB_Registration::with('event')->findOrFail($id);
        return view('admin.registrations.OB_show', compact('registration'));
    }

    // DELETE
    public function destroy($id)
    {
        $registration = OB_Registration::findOrFail($id);
        $registration->delete();

        return back()->with('success', 'Registration deleted successfully');
    }
}
