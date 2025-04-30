<?php

namespace App\Http\Controllers;

use App\Models\AvailableSlot;
use App\Models\TimeSlot;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ManageDatesController extends Controller
{
    public function getTimeSlots($date)
    {
        // Example: Parse and validate the date
        try {
            $parsedDate = Carbon::parse($date);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Invalid date format'], 400);
        }
        $Slots = AvailableSlot::with('timeSlot')
            ->where('date', $parsedDate)
            ->where('is_blocked', false)
            ->whereDoesntHave('booking') // If using `bookings` table
            ->get();

        $formattedSlots = $Slots->map(function ($slot) {
            if (!$slot->timeSlot) {
                return null; // or handle it gracefully
            }

            return [
                'slot_id' => $slot->id,
                'date' => $slot->date,
                'start' => Carbon::createFromFormat('H:i:s', $slot->timeSlot->start_time)->format('H:i'),
                'end' => Carbon::createFromFormat('H:i:s', $slot->timeSlot->end_time)->format('H:i'),
            ];
        })->filter()->values()->toArray();


        // Return formatted slots as a JSON response
        return response()->json($formattedSlots);
    }

    public function handleForm(Request $request)
    {

        return $request->all();
        // Validate the form data
        $validator = Validator::make($request->all(), [
            'date' => 'required|date|after_or_equal:today', // Date must be today or in the future
            'time' => 'required|in:' . implode(',', TimeSlot::pluck('start_time')->toArray()), // Ensure time exists in available slots
        ]);

        if ($validator->fails()) {
            /*  return redirect()->back()->withErrors($validator)->withInput(); */
            return implode(',', TimeSlot::pluck('start_time')->toArray());
        } else {
            return "exito";
        }

        $selectedDate = Carbon::parse($request->date);
        $selectedTime = $request->time;



    }

}
