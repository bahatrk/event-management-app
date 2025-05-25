@php $basketCount = count(session('basket', [])); @endphp
<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ url('/events') }}">
                        <x-application-logo class="block h-20 w-auto text-gray-800" />
                    </a>
                </div>

                @if (auth()->check())
                    <!-- Navigation Links -->
                    <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">

                        @if (auth()->user()->isAdmin())
                            <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                                <!-- Admin Dashboard Icon -->
                                <span>{{ __('Dashboard') }}</span>
                                <span
                                    class="inline-flex items-center px-2 py-0.5 text-xs font-semibold text-white bg-red-600 rounded-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 me-1" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12 2L2 7l10 5 10-5-10-5z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2 17l10 5 10-5" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2 12l10 5 10-5" />
                                    </svg>
                                    Admin
                                </span>
                            </x-nav-link>
                        @endif
                        <x-nav-link :href="route('events.my')" :active="request()->routeIs('events.my')">
                            {{ __('My Events') }}
                        </x-nav-link>
                        <x-nav-link :href="route('notifications.index')" :active="request()->routeIs('notifications.index')">
                            {{ __('Notifications') }}
                        </x-nav-link>

                        @if (auth()->user()->isAdmin())
                            <x-nav-link :href="route('admin.events.index')" :active="request()->routeIs('admin.events.*')">
                                <!-- Admin Events Icon -->
                                <span>{{ __('Events') }}</span>
                                <span
                                    class="inline-flex items-center px-2 py-0.5 text-xs font-semibold text-white bg-red-600 rounded-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 me-1" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12 2L2 7l10 5 10-5-10-5z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2 17l10 5 10-5" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2 12l10 5 10-5" />
                                    </svg>
                                    Admin
                                </span>
                            </x-nav-link>

                            <x-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.index')">
                                <!-- Admin User Icon -->
                                <span>{{ __('Users') }}</span>
                                <span
                                    class="inline-flex items-center px-2 py-0.5 text-xs font-semibold text-white bg-red-600 rounded-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 me-1" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12 2L2 7l10 5 10-5-10-5z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2 17l10 5 10-5" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2 12l10 5 10-5" />
                                    </svg>
                                    Admin
                                </span>
                            </x-nav-link>
                        @endif
                    </div>
                @endif
            </div>


            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <!-- Basket -->
                <a href="{{ route('basket.view') }}"
                    class="relative inline-flex items-center p-2 text-gray-500 hover:text-gray-700 focus:outline-none focus:text-gray-700 transition duration-150 ease-in-out me-4">
                    <!-- Container for icon and badge -->
                    <div class="relative">
                        <!-- Basket SVG Icon -->
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 3h2l.4 2M7 13h10l4-8H5.4" />
                            <circle cx="7" cy="21" r="1" />
                            <circle cx="17" cy="21" r="1" />
                        </svg>
                        @if ($basketCount > 0)
                            <span
                                class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white bg-red-600 rounded-full transform translate-x-1/2 -translate-y-1/2">
                                {{ $basketCount }}
                            </span>
                        @endif
                    </div>
                </a>
                <!-- Settings Dropdown -->
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>

                <!-- Notification Bell -->
                @php
                    $unreadCount = auth()->user()->unreadNotifications()->count();
                @endphp
                <a href="{{ route('notifications.index') }}"
                    class="relative inline-flex items-center p-2 text-gray-500 hover:text-gray-700 focus:outline-none focus:text-gray-700 transition duration-150 ease-in-out me-4"
                    title="Notifications">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path
                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 10-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>

                    @if ($unreadCount > 0)
                        <span
                            class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white bg-red-600 rounded-full transform translate-x-1/2 -translate-y-1/2">
                            {{ $unreadCount }}
                        </span>
                    @endif
                </a>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <!-- Basket -->
                <a href="{{ route('basket.view') }}"
                    class="relative inline-flex items-center p-2 text-gray-500 hover:text-gray-700 focus:outline-none focus:text-gray-700 transition duration-150 ease-in-out me-4">
                    <!-- Container for icon and badge -->
                    <div class="relative">
                        <!-- Basket SVG Icon -->
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                            stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 3h2l.4 2M7 13h10l4-8H5.4" />
                            <circle cx="7" cy="21" r="1" />
                            <circle cx="17" cy="21" r="1" />
                        </svg>
                        @if ($basketCount > 0)
                            <span
                                class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white bg-red-600 rounded-full transform translate-x-1/2 -translate-y-1/2">
                                {{ $basketCount }}
                            </span>
                        @endif
                    </div>
                </a>
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">

        @if (auth()->user()->isAdmin())
            <div class="pt-2 pb-3 space-y-1">
                <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                    <span>{{ __('Dashboard') }}</span>
                    <span
                        class="inline-flex items-center px-2 py-0.5 text-xs font-semibold text-white bg-red-600 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 me-1" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 2L2 7l10 5 10-5-10-5z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2 17l10 5 10-5" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2 12l10 5 10-5" />
                        </svg>
                        Admin
                    </span>
                </x-responsive-nav-link>
            </div>
        @endif




        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">

            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
