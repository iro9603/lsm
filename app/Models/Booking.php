<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = ['user_id', 'available_slot_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function availableSlot()
    {
        return $this->belongsTo(AvailableSlot::class);
    }
}
