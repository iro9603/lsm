<?php

namespace Database\Seeders;

use App\Models\TimeSlot;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class TimeSlotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $time_slots_start = [
            '00:00:00',
            '00:30:00',
            '01:00:00',
            '01:30:00',
            '02:00:00',
            '02:30:00',
            '03:00:00',
            '03:30:00',
            '04:00:00',
            '04:30:00',
            '05:00:00',
            '05:30:00',
            '06:00:00',
            '06:30:00',
            '07:00:00',
            '07:30:00',
            '08:00:00',
            '08:30:00',
            '09:00:00',
            '09:30:00',
            '10:00:00',
            '10:30:00',
            '11:00:00',
            '11:30:00',
            '12:00:00',
            '12:30:00',
            '13:00:00',
            '13:30:00',
            '14:00:00',
            '14:30:00',
            '15:00:00',
            '15:30:00',
            '16:00:00',
            '16:30:00',
            '17:00:00',
            '17:30:00',
            '18:00:00',
            '18:30:00',
            '19:00:00',
            '19:30:00',
            '20:00:00',
            '20:30:00',
            '21:00:00',
            '21:30:00',
            '22:00:00',
            '22:30:00',
            '23:00:00',
            '23:30:00'

        ];




        foreach ($time_slots_start as $startTime) {

            $endTime = Carbon::createFromFormat('H:i:s', $startTime)->addHour()->format('H:i:s');

            TimeSlot::firstOrCreate([
                'start_time' => $startTime,
                'end_time' => $endTime
            ]);
        }
    }
}
