<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AvailableSlot extends Model
{
    protected $fillable = ['date', 'time_slot_id'];

    public function timeSlot()
    {
        return $this->belongsTo(TimeSlot::class);
    }

    public function booking()
    {
        return $this->hasOne(Booking::class);
    }
}
