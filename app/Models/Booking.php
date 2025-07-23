<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

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

    public function scopeMineBooked($query)
    {
        return $query->with(['availableSlot.timeSlot', 'user'])
            ->where('user_id', Auth::id())
            ->whereHas('availableSlot.timeSlot', function ($q) {
                $q->where('is_booked', true);
            })
            ->orderBy('created_at', 'desc');
    }
}
