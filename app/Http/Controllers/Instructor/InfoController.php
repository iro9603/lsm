<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;

class InfoController extends Controller
{
    public function index()
    {
        return view('instructor.info.index');
    }
}
