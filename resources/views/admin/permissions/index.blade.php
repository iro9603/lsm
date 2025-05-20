<x-admin-layout :breadcrumb="[
        [
            'name' => 'Dashboard',
            'url' => route('admin.dashboard')
        ],
        [
            'name' => 'Permisos',

        ]
    ]">

    <x-slot name="action">
        <a class="btn btn-blue text-xs" href="{{ route('admin.permissions.create') }}">
            Nuevo
        </a>
    </x-slot>


    @livewire('permission-table')


</x-admin-layout>