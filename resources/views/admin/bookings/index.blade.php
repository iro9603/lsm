<x-admin-layout :breadcrumb="[
        [
            'name' => 'Dashboard',
            'url' => route('admin.dashboard')
        ],
        [
            'name' => 'Reservaciones',

        ]
    ]">

    <x-slot name="action">
        <a class="btn btn-blue text-xs" href="{{ route('admin.bookings.create') }}">
            Nuevo
        </a>
    </x-slot>


    @livewire('bookings-table')


</x-admin-layout>