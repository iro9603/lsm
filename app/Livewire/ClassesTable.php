<?php

namespace App\Livewire;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Rappasoft\LaravelLivewireTables\Views\Columns\LinkColumn;

class ClassesTable extends DataTableComponent
{
    protected $model = Booking::class;



    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }



    public function builder(): \Illuminate\Database\Eloquent\Builder
    {
        $is_booked = true;
        return Booking::query()
            ->with(['availableSlot.timeSlot', 'user']) // Relaciones necesarias
            ->where('user_id', Auth::id())// Filtra por usuario logueado
            ->whereHas('availableSlot.timeSlot', function ($q) use ($is_booked) {
                $q->where('is_booked', $is_booked);
            }); // Filtra las lecciones reservadas por el usuario 
    }

    public function columns(): array
    {
        return [
            Column::make("Clase ID", "id")
                ->sortable(),
            Column::make("Nombre del usuario", "user_id")
                ->format(fn($value, $row) => optional($row->user)->name),
            Column::make("email", "user_id")
                ->format(fn($value, $row) => optional($row->user)->email),
            Column::make("Fecha", "available_slot_id")
                ->format(fn($value, $row) => optional($row->availableSlot)->date)
                ->sortable(),
            Column::make("Hora", "available_slot_id")
                ->format(function ($value, $row) {
                    $start_time = optional($row->availableSlot->timeSlot)->start_time;
                    return Carbon::createFromFormat('H:i:s', $start_time)->format('g:i A');
                })
                ->sortable(),
            LinkColumn::make("Edit")->title(fn($row) => "Editar")->location(fn($row) => route('admin.roles.edit', $row))

        ];
    }
}
