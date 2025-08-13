<?php

namespace App\Http\Controllers;

use App\Models\User;


class TutorsController extends Controller
{
    public function index()
    {
        $tutors = User::role('instructor')->get();

        return view('tutors.index', compact('tutors'));
    }

    public function show(User $user)
    {
        if (!$user->hasRole('instructor')) {
            abort(404); // o 403 si quieres indicar acceso prohibido
        }

        return view('tutors.show', compact('user'));
    }
}
