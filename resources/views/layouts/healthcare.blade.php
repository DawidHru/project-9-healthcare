<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Healthcare System') }} - @yield('title')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50">
    <!-- Sidebar -->
    <div class="fixed inset-y-0 left-0 w-64 bg-blue-800 text-white transition-transform duration-300 transform" id="sidebar">
        <div class="flex items-center justify-between h-16 px-4 bg-blue-900">
            <div class="flex items-center">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
                <span class="ml-2 text-xl font-semibold">Healthcare</span>
            </div>
            <button id="sidebar-toggle" class="lg:hidden">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <nav class="mt-5 px-2">
            <a href="{{ route('dashboard') }}" class="group flex items-center px-2 py-2 text-base font-medium rounded-md {{ request()->routeIs('dashboard') ? 'bg-blue-900 text-white' : 'text-blue-100 hover:bg-blue-700 hover:text-white' }}">
                <svg class="mr-4 h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                Dashboard
            </a>

            <a href="{{ route('insurance.index') }}" class="mt-1 group flex items-center px-2 py-2 text-base font-medium rounded-md {{ request()->routeIs('insurance.*') ? 'bg-blue-900 text-white' : 'text-blue-100 hover:bg-blue-700 hover:text-white' }}">
                <svg class="mr-4 h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                </svg>
                Insurance
            </a>

            <a href="{{ route('bills.index') }}" class="mt-1 group flex items-center px-2 py-2 text-base font-medium rounded-md {{ request()->routeIs('bills.*') ? 'bg-blue-900 text-white' : 'text-blue-100 hover:bg-blue-700 hover:text-white' }}">
                <svg class="mr-4 h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                </svg>
                Billing
            </a>

            <a href="{{ route('appointments.index') }}" class="mt-1 group flex items-center px-2 py-2 text-base font-medium rounded-md {{ request()->routeIs('appointments.*') ? 'bg-blue-900 text-white' : 'text-blue-100 hover:bg-blue-700 hover:text-white' }}">
                <svg xmlns="http://www.w3.org/2000/svg" class="ml-0.5 mr-4 h-5 w-5" viewBox="0 0 24 24" fill="#ffffff">
                    <path d="M7 14C7 13.4477 7.44772 13 8 13C8.55229 13 9 13.4477 9 14C9 14.5523 8.55229 15 8 15C7.44772 15 7 14.5523 7 14Z" fill="currentColor"/>
                    <path d="M8 17C7.44772 17 7 17.4477 7 18C7 18.5523 7.44772 19 8 19C8.55229 19 9 18.5523 9 18C9 17.4477 8.55229 17 8 17Z" fill="currentColor"/>
                    <path d="M11 14C11 13.4477 11.4477 13 12 13C12.5523 13 13 13.4477 13 14C13 14.5523 12.5523 15 12 15C11.4477 15 11 14.5523 11 14Z" fill="currentColor"/>
                    <path d="M12 17C11.4477 17 11 17.4477 11 18C11 18.5523 11.4477 19 12 19C12.5523 19 13 18.5523 13 18C13 17.4477 12.5523 17 12 17Z" fill="currentColor"/>
                    <path d="M15 14C15 13.4477 15.4477 13 16 13C16.5523 13 17 13.4477 17 14C17 14.5523 16.5523 15 16 15C15.4477 15 15 14.5523 15 14Z" fill="currentColor"/>
                    <path d="M16 17C15.4477 17 15 17.4477 15 18C15 18.5523 15.4477 19 16 19C16.5523 19 17 18.5523 17 18C17 17.4477 16.5523 17 16 17Z" fill="currentColor"/>
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M6 2C6 1.44772 6.44772 1 7 1C7.55228 1 8 1.44772 8 2V3H16V2C16 1.44772 16.4477 1 17 1C17.5523 1 18 1.44772 18 2V3H19C20.6569 3 22 4.34315 22 6V20C22 21.6569 20.6569 23 19 23H5C3.34315 23 2 21.6569 2 20V6C2 4.34315 3.34315 3 5 3H6V2ZM16 5V6C16 6.55228 16.4477 7 17 7C17.5523 7 18 6.55228 18 6V5H19C19.5523 5 20 5.44772 20 6V9H4V6C4 5.44772 4.44772 5 5 5H6V6C6 6.55228 6.44772 7 7 7C7.55228 7 8 6.55228 8 6V5H16ZM4 11V20C4 20.5523 4.44772 21 5 21H19C19.5523 21 20 20.5523 20 20V11H4Z" fill="currentColor"/>
                    </svg>
                Appointments
            </a>

            <a href="{{ route('lab-results.index') }}" class="mt-1 group flex items-center px-2 py-2 text-base font-medium rounded-md {{ request()->routeIs('lab-results.*') ? 'bg-blue-900 text-white' : 'text-blue-100 hover:bg-blue-700 hover:text-white' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="ml-0.5 mr-4 h-5 w-5" viewBox="0 0 24 24"><path d="M22,21H21V14a3,3,0,0,0-3-3H14.172V8.945a4.987,4.987,0,0,0,6.363-.581,1,1,0,0,0,0-1.414L14.879,1.293a1,1,0,0,0-1.414,0A4.968,4.968,0,0,0,12,4.828a4.985,4.985,0,0,0,.172,1.234V11H8V8.816a3,3,0,1,0-2,0V11a3,3,0,0,0-3,3v7H2a1,1,0,0,0,0,2H22a1,1,0,0,0,0-2ZM14.292,3.534l4,4a3.066,3.066,0,0,1-3.415-.587,3.005,3.005,0,0,1-.587-3.416ZM7,5A1,1,0,1,1,6,6,1,1,0,0,1,7,5Zm5,16H9V19a1.5,1.5,0,0,1,3,0Zm7-6H16a1,1,0,0,0,0,2h3v4H14V19a3.5,3.5,0,0,0-7,0v2H5V14a1,1,0,0,1,1-1H18a1,1,0,0,1,1,1Z"/></svg>
                Lab Results
            </a>

        </nav>
    </div>

    <!-- Main Content -->
    <div class="lg:pl-64 flex flex-col flex-1">
        <!-- Top Navigation -->
        <div class="sticky top-0 z-10 flex-shrink-0 flex h-16 bg-white shadow">
            <div class="flex-1 px-4 flex justify-between">
                <div class="flex-1 flex">
                    <div class="w-full flex md:ml-0">
                        <div class="relative w-full text-gray-400 focus-within:text-gray-600">
                            <div class="absolute inset-y-0 left-0 flex items-center pointer-events-none">
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <input type="search" placeholder="Search..." class="block w-full mt-3 pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        </div>
                    </div>
                </div>
                <div class="ml-4 flex items-center md:ml-6">


                    <!-- User Menu -->
                    <div class="ml-2 mr-3 relative">
                        <div>
                            <button type="button" class="max-w-xs bg-white flex items-center text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                                <span class="sr-only">Open user menu</span>
                                <img class="h-8 w-8 rounded-full" src="https://ui-avatars.com/api/?name={{ auth()->user()->name }}" alt="{{ auth()->user()->name }}">
                            </button>
                        </div>

                        <!-- Profile dropdown menu -->
                        <div class="hidden origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1" id="user-menu">
                            <div class="px-4 py-3 border-b border-gray-100">
                                <p class="text-sm font-medium text-gray-900">{{ Auth::user()->name }}</p>
                                <p class="text-sm text-gray-500">{{ Auth::user()->email }}</p>
                            </div>
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem" tabindex="-1">Profile Settings</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem" tabindex="-1">
                                    Sign out
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Page Content -->
        <main class="flex-1 relative overflow-y-auto focus:outline-none">
            <div class="py-6">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
                    <h1 class="text-2xl font-semibold text-gray-900">@yield('header')</h1>
                </div>

                <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
                    @if (session('success'))
                        <div class="mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded" role="alert">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm">{{ session('success') }}</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="mb-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded" role="alert">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm">{{ session('error') }}</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    @yield('content')
                </div>
            </div>
        </main>
    </div>

    @stack('scripts')
    <script>
        // Sidebar Toggle
        const sidebar = document.getElementById('sidebar');
        const sidebarToggle = document.getElementById('sidebar-toggle');

        sidebarToggle.addEventListener('click', () => {
            sidebar.classList.toggle('-translate-x-full');
        });

        // Close sidebar on mobile when clicking outside
        document.addEventListener('click', (e) => {
            if (window.innerWidth < 1024 && !sidebar.contains(e.target) && !sidebarToggle.contains(e.target)) {
                sidebar.classList.add('-translate-x-full');
            }
        });

        // Profile dropdown toggle
        const userMenuButton = document.getElementById('user-menu-button');
        const userMenu = document.getElementById('user-menu');

        userMenuButton.addEventListener('click', () => {
            userMenu.classList.toggle('hidden');
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', (e) => {
            if (!userMenuButton.contains(e.target) && !userMenu.contains(e.target)) {
                userMenu.classList.add('hidden');
            }
        });
    </script>
</body>
</html>
