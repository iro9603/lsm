<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TimeSlot extends Model
{
    protected $fillable = ['start_time', 'end_time'];

    public function availableSlots()
    {
        return $this->hasMany(AvailableSlot::class);
    }
}
