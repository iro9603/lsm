<?php

namespace App\Http\Controllers;

use App\Models\AvailableSlot;
use App\Models\TimeSlot;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ManageDatesController extends Controller
{
    public function getTimeSlotsperDay($date)
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


    public function getTimeSlots(Request $request)
    {
        // Example: Parse and validate the date

        $Slots = AvailableSlot::with('timeSlot')
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


        // Validate the form data
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'date' => 'required|date|after_or_equal:today', // Date must be today or in the future
            'time' => ['required', Rule::in(TimeSlot::pluck('start_time')->toArray())], // Ensure time exists in available slots
        ]);

        $email = $request->input('email');
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Validar que la fecha+hora no estén en el pasado
        $selectedDateTime = Carbon::parse($request->input('date') . ' ' . $request->input('time'));

        if ($selectedDateTime->lt(Carbon::now())) {

            return redirect()->back()->withErrors([
                'time' => 'No puedes seleccionar una hora que ya pasó.',
            ])->withInput();
        }



        /*  return view('booklesson', compact('selectedDate', 'selectedDateTime')); */
        return view('booklesson')->with([
            'selectedTime' => $request->input('time'),
            'selectedDate' => $selectedDateTime->toDateString(),
            'email' => $email
        ]);

    }

}
