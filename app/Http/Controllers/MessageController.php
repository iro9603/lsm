<?php

namespace App\Http\Controllers;

use App\Models\User;

class MessageController extends Controller
{

    public function index($id)
    {

        $tutor = User::find($id);

        if ($tutor) {
            return view('messages.index', ['tutor' => $tutor]);
        }
    }
}
