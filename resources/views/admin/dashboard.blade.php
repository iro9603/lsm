<x-admin-layout :breadcrumb="[
        [
            'name' => 'Dashboard',
            'url' => '#'
        ],
        [
            'name' => 'Projects',

        ]
    ]">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="card">
            <div class="flex">
                <img class="h-8 w-8 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}"
                    alt="{{ Auth::user()->name }}" />
                <div class="ml-4">
                    <p class="text-lg font-semibold">
                        Bienvenido, {{ Auth::user()->name }}
                    </p>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button class="text-sm hover:text-blue-500">
                            Cerrar Sesión
                        </button>
                    </form>
                </div>
            </div>

        </div>
        <div class="card">
            <div class="flex  items-center justify-center h-full">
                <p class="text-2xl font-semibold">
                    Ndexi Maths Center
                </p>
            </div>
        </div>
    </div>
</x-admin-layout>