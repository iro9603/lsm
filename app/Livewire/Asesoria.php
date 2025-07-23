<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\AvailableSlot;
use Carbon\Carbon;

class Asesoria extends Component
{

    public function index()
    {

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

        return view('livewire.asesoria', compact('formattedSlots'));
    }
}
