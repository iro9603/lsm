<x-admin-layout :breadcrumb="[
        [
            'name' => 'Dashboard',
            'url' => route('admin.dashboard')
        ],
        [
            'name' => 'Roles',
            'url' => route('admin.roles.index')
        ],
        [
            'name' => 'Editar',

        ]
    ]">




    <div class="card">
        <form action="{{ route('admin.roles.update', $role) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <x-label class="mb-1">
                    Nombre
                </x-label>

                <x-input name="name" value="{{ old('name', $role->name) }}" class="w-full" />
            </div>

            <div class="mb-4">
                <x-label class="mb-1">
                    Permisos
                </x-label>
                <ul>
                    @foreach ($permissions as $permission)
                        <li>
                            <label>
                                <x-checkbox name="permissions[]" value="{{ $permission->id }}"
                                    :checked="in_array($permission->id, old('permissions', $role->permissions->pluck('id')->toArray()))" />
                                {{ $permission->name }}
                            </label>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="flex justify-end space-x-2">
                <x-danger-button onclick="confirmDelete()">Eliminar</x-danger-button>
                <x-button>
                    Actualizar
                </x-button>
            </div>
        </form>

        <form action="{{ route('admin.roles.destroy', $role) }}" method="POST" id="deleteForm">
            @csrf
            @method('DELETE')
        </form>

    </div>
    @push('js')
        <script>
            function confirmDelete() {
                Swal.fire({
                    title: "¿Estás seguro?",
                    text: "No podras revertir esto!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Si, borrar!",
                    cancelButtonText: "Cancelar"
                }).then((result) => {
                    if (result.isConfirmed) {

                        document.getElementById('deleteForm').submit();

                    }
                });
            }
        </script>
    @endpush

</x-admin-layout>