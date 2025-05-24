<x-admin-layout :breadcrumb="[
        [
            'name' => 'Dashboard',
            'url' => route('admin.dashboard')
        ],
        [
            'name' => 'Calendario',

        ]
    ]">



    <x-slot name="action">
        <a class="btn btn-blue text-xs" href="{{ route('admin.calendar.create') }}">
            Nuevo
        </a>
    </x-slot>



    <div id="calendar"></div>


    {{-- @livewire('permission-table')
    --}}
    @push('js')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @endpush
</x-admin-layout>