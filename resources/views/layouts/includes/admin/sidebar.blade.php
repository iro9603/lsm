
@php
    $links = [
        [
            'name' => 'Dashboard',
            'icon' => 'fa-solid fa-gauge',
            'route' => route('admin.dashboard'),
            'active' => request()->routeIs('admin.dashboard'),
            'can' => ['access_dashboard']
        ],

        [
            'header' => 'Administrar página',
            'can' => ['manage_users', 'manage_roles', 'manage_permissions']
        ],

      /*   [
            'name' => 'Calendario',
            'icon' => 'fa-regular fa-calendar',
            'route' => route('admin.calendar.index'),
            'active' => request()->routeIs('admin.calendar.*'),
            'can' => ['access_dashboard']
        ], */
        [
            'name' => 'Usuarios',
            'icon' => 'fa-solid fa-users',
            'route' => route('admin.users.index'),
            'active' => request()->routeIs('admin.users.*'),
            'can' => ['manage_users']
        ],

        [
            'name' => 'Roles',
            'icon' => 'fa-solid fa-user-tag',
            'route' => route('admin.roles.index'),
            'active' => request()->routeIs('admin.roles.*'),
            'can' => ['manage_roles']
        ],
        [
            'name' => 'Permisos',
            'icon' => 'fa-solid fa-lock-open',
            'route' => route('admin.permissions.index'),
            'active' => request()->routeIs('admin.permissions.*'),
            'can' => ['manage_permissions']
        ],
        [
            'name' => 'Reservaciones',
            'icon' => 'fa-regular fa-calendar',
            'active' => request()->routeIs('admin.calendar.*') || request()->routeIs('admin.bookings.*'),
            'can' => ['access_dashboard'],
            'submenu' => [
                [
                    'name' => 'Calendario',
                    'icon' => 'fa-regular fa-circle',
                    'route' => route('admin.calendar.index'),
                    'active' => request()->routeIs('admin.calendar.index'),
                    'can' => ['access_dashboard']
                ],
                [
                    'name' => 'Tabla Reservaciones',
                    'icon' => 'fa-regular fa-circle',
                    'route' => route('admin.bookings.index'),
                    'active' => request()->routeIs('admin.bookings.*'),
                    'can' => ['access_dashboard']
                ],


            ]
        ]
    ];
@endphp

<aside id="logo-sidebar" 
    class="fixed top-0 left-0 z-40 w-64 h-screen pt-20 transition-transform -translate-x-full bg-white border-r border-gray-200 sm:translate-x-0 dark:bg-gray-800 dark:border-gray-700" aria-label="Sidebar"
    :class="{
        'transform-none': open,
        '-translate-x-full': !open,
    }"
    >
    <div class="h-full px-3 pb-4 overflow-y-auto bg-white dark:bg-gray-800">
        <ul class="space-y-2 font-medium">
        @foreach ( $links as $link )
            @canany($link['can'] ?? [null])
                <li>
                @isset($link['header'])
                    <div class="px-3 py-2 text-xs font-semibold text-gray-500 uppercase">{{$link['header']}}</div>
                @else

                    @isset($link['submenu'])
                        <div x-data="{open: {{$link['active'] ? 'true': 'false'}}}">
                            <button class="flex items-center w-full p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{$link['active'] ? 'bg-gray-300' : ''}}" x-on:click="open = !open">
                            
                                <span class="inline-flex w-6 h-6 justify-center items-center">
                                    <i class="{{$link['icon']}}"></i>
                                </span>
                                <span class="ms-3 text-left flex-1">
                                    {{$link['name']}}
                                </span>

                                <i class="fa-solid fa-angle-down"
                                :class="{
                                    'fa-angle-down': !open,
                                    'fa-angle-up': open
                                }"
                                ></i>
                            </button>
                            <ul x-show="open" x-cloak>
                                @foreach ( $link['submenu'] as $item)
                                    <li class="pl-4">
                                        <a href="{{$item['route']}}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{$item['active'] ? 'bg-gray-300' : ''}}">
                                            <span class="inline-flex w-6 h-6 justify-center items-center">
                                                <i class="{{$item['icon']}}"></i>
                                            </span>
                                            <span class="ms-3 text-left flex-1">
                                                {{$item['name']}}
                                            </span>
                                        </a>
                                    </li>
                                    
                                @endforeach
                            </ul>
                        </div>
                    @else
                        <a href="{{$link['route']}}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group {{$link['active'] ? 'bg-gray-300' : ''}}">
                            <span class="inline-flex w-6 h-6 justify-center items-center">
                                <i class="{{$link['icon']}}"></i>
                            </span>
                            <span class="ms-3">{{$link['name']}}</span>
                        </a>     
                    @endisset
                   
                @endisset
                </li>
            @endcanany
        
        @endforeach    
        </ul>
    </div>
</aside>