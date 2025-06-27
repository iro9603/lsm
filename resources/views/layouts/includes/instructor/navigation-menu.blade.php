@php
$links = [
[
'name' => 'Cursos',
'route' => route('instructor.courses.index'),
'active' => request()->routeIs('instructor.courses.index')
]
];
@endphp

<nav x-data="{ open: false }" class=" bg-indigo-950 shadow-md hover:bg-indigo-900">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="/">
                        <x-application-mark class="block h-9 w-auto" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8  sm:-my-px sm:ms-10 sm:flex ">
                    @foreach ($links as $item)

                    <x-nav-link class="text-xl text-white hover:text-blue-800 hover:bg-blue-50  transition"
                        href="{{ $item['route'] }}" :active="$item['active']">
                        {{ $item['name'] }}
                    </x-nav-link>
                    @endforeach
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <!-- Settings Dropdown -->
                <div class="ms-3 relative">
                    @auth
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                            <button
                                class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                <img class="h-8 w-8 rounded-full object-cover"
                                    src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                            </button>
                            @else
                            <span class="inline-flex rounded-md">
                                <button type="button"
                                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">
                                    {{ Auth::user()->name }}

                                    <svg class="ms-2 -me-0.5 size-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                    </svg>
                                </button>
                            </span>
                            @endif
                        </x-slot>

                        <x-slot name="content">
                            <!-- Account Management -->
                            <div class="block px-4 py-2 text-xs text-gray-400">
                                {{ __('Manage Account') }}
                            </div>

                            <x-dropdown-link href="{{ route('profile.show') }}">
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            <x-dropdown-link href="{{ route('courses.myCourses') }}">
                                Mis cursos
                            </x-dropdown-link>

                            @can('manage_courses')
                            <x-dropdown-link href="{{ route('instructor.courses.index') }}">
                                Instructor
                            </x-dropdown-link>
                            @endcan

                            <x-dropdown-link href="{{ route('classes.myClasses') }}">
                                Mis clases
                            </x-dropdown-link>

                            @can('access_dashboard')
                            <x-dropdown-link href="{{ route('admin.dashboard') }}">
                                Administrador
                            </x-dropdown-link>
                            @endcan


                            <div class="border-t border-gray-200"></div>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}" x-data>
                                @csrf

                                <x-dropdown-link href="{{ route('logout') }}" @click.prevent="$root.submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>

                    @else

                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="text-indigo-400 hover:text-yellow-500">
                                <i class="fa-solid fa-user text-2xl"></i>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <!-- Account Management -->
                            <div class="block px-4 py-2 text-xs text-gray-400">
                                {{ __('Manage Account') }}
                            </div>

                            <x-dropdown-link href="{{ route('login') }}">
                                Iniciar Sesión
                            </x-dropdown-link>

                            <x-dropdown-link href="{{ route('register') }}">
                                Registrarse
                            </x-dropdown-link>

                        </x-slot>
                    </x-dropdown>

                    @endauth
                </div>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-yellow-500 focus:outline-none focus:bg-yellow-500 focus:text-white transition duration-150 ease-in-out">
                    <svg class="size-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            @foreach ($links as $item)

            <x-responsive-nav-link
                class="{{ $item['active'] ? 'text-blue-500  bg-blue-50' : 'text-white' }}   px-4 py-2 rounded-md transition font-medium"
                href="{{ $item['route'] }}" :active="$item['active']">
                {{ $item['name'] }}
            </x-responsive-nav-link>
            @endforeach

            @auth


            @else
            <x-responsive-nav-link
                class="{{ $item['active'] ? 'text-blue-500  bg-blue-50' : 'text-white' }}   px-4 py-2 rounded-md transition font-medium"
                href="{{route('login')}}">
                Iniciar Sesión
            </x-responsive-nav-link>

            <x-responsive-nav-link
                class="{{ $item['active'] ? 'text-blue-500  bg-blue-50' : 'text-white' }}   px-4 py-2 rounded-md transition font-medium"
                href="{{ route('register') }}">
                Registrarse
            </x-responsive-nav-link>
            @endauth

        </div>

        <!-- Responsive Settings Options -->
        @auth
        <div class="pt-4 pb-1 border-t border-gray-200">

            <div class="flex items-center px-4">
                @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                <div class="shrink-0 me-3">
                    <img class="size-10 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}"
                        alt="{{ Auth::user()->name }}" />
                </div>
                @endif

                <div>
                    <div class="font-medium text-base text-yellow-500">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-300">{{ Auth::user()->email }}</div>
                </div>
            </div>


            <div class="mt-3 space-y-1">
                <!-- Account Management -->
                <x-responsive-nav-link class="text-white  px-4 py-2 rounded-md transition font-medium"
                    href="{{ route('profile.show') }}" :active="request()->routeIs('profile.show')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}" x-data>
                    @csrf

                    <x-responsive-nav-link class=" text-white  px-4 py-2 rounded-md transition font-medium"
                        href="{{ route('logout') }}" @click.prevent="$root.submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
        @endauth
    </div>
</nav>