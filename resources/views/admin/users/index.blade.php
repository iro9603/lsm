<x-admin-layout :breadcrumb="[
        [
            'name' => 'Dashboard',
            'url' => route('admin.dashboard')
        ],
        [
            'name' => 'Usuarios',

        ]
    ]">

    <x-slot name="action">
        <a class="btn btn-blue text-xs" href="{{ route('admin.users.create') }}">
            Nuevo
        </a>
    </x-slot>
    @livewire('user-table')



</x-admin-layout>