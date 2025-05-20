<x-admin-layout :breadcrumb="[
        [
            'name' => 'Dashboard',
            'url' => route('admin.dashboard')
        ],
        [
            'name' => 'Permisos',
            'url' => route('admin.permissions.index')
        ],
        [
            'name' => $permission->name,

        ]
    ]">




</x-admin-layout>