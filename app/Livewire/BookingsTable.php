<?php

namespace App\Livewire;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Booking;
use Rappasoft\LaravelLivewireTables\Views\Columns\LinkColumn;

class BookingsTable extends DataTableComponent
{
    protected $model = Booking::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make("User id", "user_id")
                ->sortable(),
            Column::make('Nombre de Usuario', 'user_id')
                ->format(fn($value, $row) => optional($row->user)->name)
                ->sortable(),
            Column::make("Available slot id", "available_slot_id")
                ->sortable(),
            Column::make("Created at", "created_at")
                ->sortable(),
            Column::make("Updated at", "updated_at")
                ->sortable(),
            Column::make("Link", "link")
                ->sortable(),
            /* LinkColumn::make("Edit")->title(fn($row) => "Editar")->location(fn($row) => route('admin.bookings.edit', $row)) */

        ];
    }
}
