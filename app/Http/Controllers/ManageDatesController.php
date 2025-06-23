<?php

namespace App\Http\Controllers;

use App\Models\AvailableSlot;
use App\Models\Booking;
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

        AvailableSlot::where('is_temporarily_blocked', true)
            ->where('temporarily_blocked_until', '<', now())
            ->update([
                'is_temporarily_blocked' => false,
                'temporarily_blocked_until' => null,
            ]);

        $Slots = AvailableSlot::with('timeSlot')
            ->where(function ($query) {
                $query->where('is_temporarily_blocked', false)
                    ->orWhere('temporarily_blocked_until', '<', Carbon::now());
            })
            ->where('date', $parsedDate)
            ->where('is_blocked', false)
            ->where('is_booked', false)
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


        //Verifica si hay conflicto 

        $time_slot_id = TimeSlot::where('start_time', $request->input('time'))->value('id');
        $available_slot_id = AvailableSlot::where('time_slot_id', $time_slot_id)
            ->where('date', $selectedDateTime->toDateString())
            ->where('is_booked', 0)
            ->where('is_blocked', 0)
            ->where(function ($query) {
                $query->where('is_temporarily_blocked', false)
                    ->orWhere('temporarily_blocked_until', '<', Carbon::now());
            })
            ->value('id');
        $slot = AvailableSlot::find($available_slot_id);

        if (!$slot || $slot->is_booked || $slot->is_blocked || $slot->is_temporarily_blocked) {
            return back()->withErrors(['conflict' => 'Este horario ya fue reservado o está en proceso de pago.']);
        }

        $exists = Booking::where('available_slot_id', $available_slot_id)->where('user_id', $request->input('email'))->exists();

        if ($exists) {
            return back()->withErrors(['conflict' => 'Este horario ya fue reservado']);
        } else {
            $slot->is_temporarily_blocked = true;
            $slot->temporarily_blocked_until = Carbon::now()->addMinutes(1);
            $slot->save();
            /*  return view('booklesson', compact('selectedDate', 'selectedDateTime')); */
            return view('booklesson')->with([
                'selectedTime' => $request->input('time'),
                'selectedDate' => $selectedDateTime->toDateString(),
                'email' => $email,
                'blocked_until' => $slot->temporarily_blocked_until->toIso8601String()
            ]);
        }
    }
}
