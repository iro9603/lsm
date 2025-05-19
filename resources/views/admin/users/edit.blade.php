<x-admin-layout :breadcrumb="[
        [
            'name' => 'Dashboard',
            'url' => route('admin.dashboard')
        ],
        [
            'name' => 'Usuarios',
            'url' => route('admin.users.index')
        ],
        [
            'name' => 'Editar',

        ]
    ]">

    <div class="card">
        <form action="{{ route('admin.users.update', $user)}}" method="POST">
            @csrf
            @method('PUT')

            <x-validation-errors class="mb-4" />
            <div class="mb-4">
                <x-label class="mb-1">
                    Nombre
                </x-label>
                <x-input name="name" value="{{ old('name', $user->name) }}" required class="w-full" />
            </div>
            <div class="mb-4">
                <x-label class="mb-1">
                    Email
                </x-label>
                <x-input type="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full" />
            </div>
            <div class="mb-4">
                <x-label class="mb-1">
                    Contraseña
                </x-label>
                <x-input type="password" name="password" class="w-full" />
            </div>
            <div class="mb-4">
                <x-label class="mb-1">
                    Confirmar contraseña
                </x-label>
                <x-input type="password" name="password_confirmation" class="w-full" />
            </div>


            <div class="mb-4">
                <x-label class="mb-1">
                    Roles
                </x-label>
                <ul>
                    @foreach ($roles as $role)
                        <li>
                            <label>
                                <x-checkbox name="roles[]" value="{{ $role->id }}" :checked="in_array($role->id, old('roles', $user->roles->pluck('id')->toArray()))" />
                                {{ $role->name }}
                            </label>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="flex justify-end space-x-2">

                <x-danger-button onclick="confirmDelete()">Eliminar</x-danger-button>

                <x-button>Actualizar</x-button>
            </div>
        </form>
    </div>

    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" id="deleteForm">
        @csrf
        @method('DELETE')
    </form>

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