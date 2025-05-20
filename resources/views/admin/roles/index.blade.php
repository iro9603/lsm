<x-admin-layout :breadcrumb="[
        [
            'name' => 'Dashboard',
            'url' => route('admin.dashboard')
        ],
        [
            'name' => 'Roles',

        ]
    ]">

    <x-slot name="action">
        <a class="btn btn-blue text-xs" href="{{ route('admin.roles.create') }}">
            Nuevo
        </a>
    </x-slot>


    @livewire('role-table')


</x-admin-layout>