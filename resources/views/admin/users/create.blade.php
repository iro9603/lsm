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
            'name' => 'Nuevo',

        ]
    ]">


    <div class="card">
        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf
            <x-validation-errors class="mb-4" />
            <div class="mb-4">
                <x-label class="mb-1">
                    Nombre
                </x-label>
                <x-input name="name" value="{{ old('name') }}" required class="w-full" />
            </div>
            <div class="mb-4">
                <x-label class="mb-1">
                    Email
                </x-label>
                <x-input type="email" name="email" value="{{ old('email') }}" required class="w-full" />
            </div>
            <div class="mb-4">
                <x-label class="mb-1">
                    Contraseña
                </x-label>
                <x-input type="password" name="password" required class="w-full" />
            </div>
            <div class="mb-4">
                <x-label class="mb-1">
                    Confirmar contraseña
                </x-label>
                <x-input type="password" name="password_confirmation" required class="w-full" />
            </div>

            <div class="mb-4">
                <x-label class="mb-1">
                    Roles
                </x-label>
                <ul>
                    @foreach ($roles as $role)
                        <li>
                            <label>
                                <x-checkbox name="roles[]" value="{{ $role->id }}" :checked="in_array($role->id, old('roles', []))" />
                                {{ $role->name }}
                            </label>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="flex justify-end">
                <x-button>Guardar</x-button>
            </div>
        </form>
    </div>

</x-admin-layout>