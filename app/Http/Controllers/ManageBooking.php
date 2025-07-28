<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\TimeSlot;
use App\Models\AvailableSlot;

class ManageBooking extends Controller
{
    public function cancelarReserva(Request $request)
    {

        // Validate the form data
        $validator = Validator::make($request->all(), [

            'date' => 'required|date|after_or_equal:today', // Date must be today or in the future
            'time' => 'required'
        ]);

        $date = $request->input('date');
        $time = $request->input('time');


        $time_slot = TimeSlot::where('start_time', $time)->firstOrFail();
        $time_slot_id = $time_slot->id;
        $available_slot = AvailableSlot::where('time_slot_id', $time_slot_id)
            ->where('date', $date)->firstOrFail();

        $available_slot->is_temporarily_blocked = false;
        $available_slot->temporarily_blocked_until = null;

        $available_slot->save();

        return  redirect()->route('asesoria');
    }
}
