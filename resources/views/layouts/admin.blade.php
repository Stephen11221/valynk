<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Overview') | VALYNK Admin Dashboard</title>

    <!-- Google Fonts & FontAwesome -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" referrerpolicy="no-referrer">

    <!-- Tailwind & Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #F8FAFC;
            color: #0F172A;
        }
        .admin-sidebar {
            background: linear-gradient(180deg, #071b22 0%, #0d1d2e 100%);
            border-right: 1px solid rgba(148, 163, 184, 0.12);
            box-shadow: inset -1px 0 0 rgba(255, 255, 255, 0.02);
        }
        .sidebar-item-active {
            background: linear-gradient(90deg, rgba(59, 130, 246, 0.28) 0%, rgba(99, 102, 241, 0.22) 100%);
            color: #FFFFFF !important;
            font-weight: 700;
            border: 1px solid rgba(96, 165, 250, 0.28);
            box-shadow: inset 0 0 0 1px rgba(255, 255, 255, 0.04), 0 8px 20px rgba(59, 130, 246, 0.14);
        }
        .sidebar-item-hover {
            color: rgba(226, 232, 240, 0.92);
        }
        .sidebar-item-hover:hover {
            background: rgba(148, 163, 184, 0.08);
            color: #FFFFFF;
        }
        #adminSidebar nav {
            scrollbar-width: none;
        }
        #adminSidebar nav::-webkit-scrollbar {
            display: none;
        }

    </style>
</head>
<body class="h-full antialiased overflow-x-hidden bg-slate-100">
    <div class="min-h-screen flex flex-col lg:flex-row">
        <div id="adminSidebarBackdrop" class="fixed inset-0 z-30 bg-slate-950/40 opacity-0 pointer-events-none transition-opacity duration-200 lg:hidden"></div>

        <!-- Sidebar -->
        <aside id="adminSidebar" class="admin-sidebar fixed inset-y-0 left-0 z-40 w-72 -translate-x-full transition-transform duration-200 ease-out lg:static lg:w-64 lg:translate-x-0 lg:min-h-screen lg:transition-none text-slate-300">
            <div>
                <!-- Brand Header -->
                <div class="px-6 py-5 border-b border-slate-800/80">
                    <div class="flex items-center justify-between gap-3">
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
                            <div class="bg-white p-1 rounded-md shadow-sm">
                                <img src="{{ asset('logo/logo.jpeg') }}" alt="VALYNK Logo" class="h-7 w-auto object-contain">
                            </div>
                            <div class="flex flex-col">
                                <span class="text-sm font-extrabold text-white tracking-wider">VALYNK</span>
                                <span class="text-[9px] font-bold text-amber-400 tracking-widest uppercase">Admin Dashboard</span>
                            </div>
                        </a>
                        <button type="button" id="closeMobileSidebar" class="ml-auto text-slate-300 hover:text-white lg:hidden" aria-label="Close menu">
                            <i class="fa-solid fa-xmark text-lg"></i>
                        </button>
                    </div>
                </div>

                <!-- Navigation Links -->
                <nav class="mt-4 px-3 space-y-1 text-xs">
                    <a href="{{ route('admin.dashboard') }}" 
                       class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg transition-all {{ request()->routeIs('admin.dashboard') ? 'sidebar-item-active' : 'sidebar-item-hover text-slate-300' }}">
                        <i class="fa-solid fa-house w-4 text-center text-sm"></i>
                        <span>Overview</span>
                    </a>

                    <a href="{{ route('admin.users', ['role' => 'family']) }}" 
                       class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg transition-all {{ request()->fullUrlIs('*role=family*') ? 'sidebar-item-active' : 'sidebar-item-hover text-slate-400' }}">
                        <i class="fa-solid fa-users w-4 text-center text-sm"></i>
                        <span>Families</span>
                    </a>

                    <a href="{{ route('admin.providers') }}" 
                       class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg transition-all {{ request()->routeIs('admin.providers') ? 'sidebar-item-active' : 'sidebar-item-hover text-slate-400' }}">
                        <i class="fa-solid fa-user-doctor w-4 text-center text-sm"></i>
                        <span>Providers</span>
                    </a>

                    <a href="{{ route('admin.users', ['role' => 'institution']) }}" 
                       class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg transition-all {{ request()->fullUrlIs('*role=institution*') ? 'sidebar-item-active' : 'sidebar-item-hover text-slate-400' }}">
                        <i class="fa-solid fa-building-columns w-4 text-center text-sm"></i>
                        <span>Institutions</span>
                    </a>

                    <a href="{{ route('admin.matches') }}" 
                       class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg transition-all {{ request()->routeIs('admin.matches') ? 'sidebar-item-active' : 'sidebar-item-hover text-slate-400' }}">
                        <i class="fa-solid fa-link w-4 text-center text-sm"></i>
                        <span>Matches</span>
                    </a>

                    <a href="{{ route('admin.transactions') }}" 
                       class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg transition-all {{ request()->routeIs('admin.transactions') ? 'sidebar-item-active' : 'sidebar-item-hover text-slate-400' }}">
                        <i class="fa-solid fa-receipt w-4 text-center text-sm"></i>
                        <span>Transactions</span>
                    </a>

                    <a href="{{ route('admin.payments') }}" 
                       class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg transition-all {{ request()->routeIs('admin.payments') ? 'sidebar-item-active' : 'sidebar-item-hover text-slate-400' }}">
                        <i class="fa-solid fa-credit-card w-4 text-center text-sm"></i>
                        <span>Payments</span>
                    </a>

                    <a href="{{ route('admin.subscriptions') }}" 
                       class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg transition-all {{ request()->routeIs('admin.subscriptions') ? 'sidebar-item-active' : 'sidebar-item-hover text-slate-400' }}">
                        <i class="fa-solid fa-tag w-4 text-center text-sm"></i>
                        <span>Subscriptions</span>
                    </a>

                          <a href="{{ route('admin.content') }}" 
                              class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg transition-all {{ request()->routeIs('admin.content') ? 'sidebar-item-active' : 'sidebar-item-hover text-slate-400' }}">
                        <i class="fa-solid fa-file-pen w-4 text-center text-sm"></i>
                        <span>Content Management</span>
                    </a>

                          <a href="{{ route('admin.reports') }}" 
                              class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg transition-all {{ request()->routeIs('admin.reports') ? 'sidebar-item-active' : 'sidebar-item-hover text-slate-400' }}">
                        <i class="fa-solid fa-chart-column w-4 text-center text-sm"></i>
                        <span>Reports & Analytics</span>
                    </a>

                          <a href="{{ route('admin.communications') }}" 
                              class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg transition-all {{ request()->routeIs('admin.communications') ? 'sidebar-item-active' : 'sidebar-item-hover text-slate-400' }}">
                        <i class="fa-solid fa-comments w-4 text-center text-sm"></i>
                        <span>Communications</span>
                    </a>

                    <a href="{{ route('admin.settings') }}#disputes" 
                       class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg transition-all sidebar-item-hover text-slate-400">
                        <i class="fa-solid fa-circle-question w-4 text-center text-sm"></i>
                        <span>Disputes & Support</span>
                    </a>

                    <a href="{{ route('admin.settings') }}" 
                       class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg transition-all {{ request()->routeIs('admin.settings') ? 'sidebar-item-active' : 'sidebar-item-hover text-slate-400' }}">
                        <i class="fa-solid fa-gear w-4 text-center text-sm"></i>
                        <span>System Settings</span>
                    </a>

                    <a href="{{ route('admin.analytics') }}#audit" 
                       class="flex items-center gap-3 px-3.5 py-2.5 rounded-lg transition-all sidebar-item-hover text-slate-400">
                        <i class="fa-solid fa-file-lines w-4 text-center text-sm"></i>
                        <span>Audit Logs</span>
                    </a>
                </nav>
            </div>

            <!-- Sidebar Bottom Support & Profile -->
            <div class="p-4 space-y-4">
                <!-- Need Help Card -->
                <div class="bg-indigo-950/60 border border-indigo-800/40 rounded-xl p-3.5 relative overflow-hidden">
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-full bg-indigo-600/30 text-indigo-400 flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-headset text-sm"></i>
                        </div>
                        <div class="text-[11px]">
                            <p class="font-bold text-white">Need Help?</p>
                            <p class="text-slate-400 font-medium text-[10px]">Admin Support</p>
                            <p class="text-indigo-300 font-mono mt-1 text-[10px]">adminsupport@valynk.co.ke</p>
                            <p class="text-indigo-300 font-mono text-[10px]">+254 700 123 456</p>
                        </div>
                    </div>
                </div>

                <!-- Admin Profile -->
                <div class="flex items-center justify-between pt-2 border-t border-slate-800/80">
                    <div class="flex items-center gap-2.5">
                        <div class="w-9 h-9 rounded-full bg-indigo-600 text-white font-bold text-xs flex items-center justify-center shadow-md">
                            AD
                        </div>
                        <div class="text-xs">
                            <p class="font-bold text-white leading-tight">Admin User</p>
                            <p class="text-[10px] text-slate-400">Super Administrator</p>
                        </div>
                    </div>
                    <a href="{{ url('/') }}" class="text-slate-400 hover:text-white text-xs" title="Return to Website">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i>
                    </a>
                </div>
            </div>
        </aside>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col min-w-0 w-full bg-[#F4F6F9]">
            <!-- Top Bar Header -->
            <header class="bg-white border-b border-slate-200/80 sticky top-0 z-30 px-4 py-3 sm:px-6 sm:py-4 shadow-2xs">
                <div class="flex items-center justify-between gap-4">
                    <div class="flex items-center gap-3 min-w-0">
                        <button id="openMobileSidebar" type="button" class="inline-flex items-center justify-center rounded-lg border border-slate-200 bg-slate-50 p-2 text-slate-700 hover:bg-slate-100 lg:hidden" aria-label="Open menu">
                            <i class="fa-solid fa-bars"></i>
                        </button>

                        <div class="min-w-0">
                            <h1 class="text-xl font-extrabold text-slate-900 tracking-tight">@yield('header_title', 'Overview')</h1>
                            <p class="text-xs font-medium text-slate-500 mt-0.5">@yield('header_subtitle', "Welcome back, Admin! Here's what's happening on VALYNK today.")</p>
                        </div>
                    </div>

                    <!-- Right Controls (Search, Badges, Date Filter) -->
                    <div class="hidden sm:flex sm:items-center sm:gap-4 sm:flex-wrap">
                        <div class="relative w-60">
                            <input type="text" placeholder="Search anything..." class="w-full pl-3.5 pr-8 py-1.5 text-xs bg-slate-50 border border-slate-200 rounded-lg focus:bg-white focus:outline-none focus:ring-2 focus:ring-indigo-500 text-slate-700">
                            <i class="fa-solid fa-magnifying-glass absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                        </div>

                        <div class="flex items-center gap-3">
                            <button class="relative p-2 text-slate-500 hover:text-slate-800 rounded-lg hover:bg-slate-100 transition-colors">
                                <i class="fa-regular fa-bell text-base"></i>
                                <span class="absolute -top-1 -right-1 bg-indigo-600 text-white text-[9px] font-bold px-1.5 py-0.2 rounded-full border-2 border-white">12</span>
                            </button>

                            <button class="relative p-2 text-slate-500 hover:text-slate-800 rounded-lg hover:bg-slate-100 transition-colors">
                                <i class="fa-regular fa-envelope text-base"></i>
                                <span class="absolute -top-1 -right-1 bg-indigo-600 text-white text-[9px] font-bold px-1.5 py-0.2 rounded-full border-2 border-white">8</span>
                            </button>
                        </div>

                        <div class="inline-flex items-center gap-2 px-3 py-1.5 text-xs font-semibold text-slate-700 bg-white border border-slate-200 rounded-lg shadow-2xs hover:bg-slate-50 cursor-pointer">
                            <i class="fa-regular fa-calendar text-slate-400"></i>
                            <span class="whitespace-nowrap">This Month: 1 – 27 May 2025</span>
                            <i class="fa-solid fa-chevron-down text-[10px] text-slate-400"></i>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Body Content -->
            <main class="flex-1 p-4 sm:p-6 space-y-4 sm:space-y-6">
                @yield('content')
            </main>
        </div>
    </div>

    <script>
        const adminSidebar = document.getElementById('adminSidebar');
        const adminSidebarBackdrop = document.getElementById('adminSidebarBackdrop');
        const openMobileSidebar = document.getElementById('openMobileSidebar');
        const closeMobileSidebar = document.getElementById('closeMobileSidebar');

        function setSidebarOpen(isOpen) {
            if (!adminSidebar || !adminSidebarBackdrop) {
                return;
            }

            if (window.innerWidth >= 1024) {
                adminSidebar.classList.remove('-translate-x-full');
                adminSidebar.classList.add('translate-x-0');
                adminSidebarBackdrop.classList.add('opacity-0');
                adminSidebarBackdrop.classList.add('pointer-events-none');
                adminSidebarBackdrop.classList.remove('opacity-100');
                document.body.classList.remove('overflow-hidden');
                return;
            }

            adminSidebar.classList.toggle('-translate-x-full', !isOpen);
            adminSidebar.classList.toggle('translate-x-0', isOpen);
            adminSidebarBackdrop.classList.toggle('opacity-0', !isOpen);
            adminSidebarBackdrop.classList.toggle('pointer-events-none', !isOpen);
            adminSidebarBackdrop.classList.toggle('opacity-100', isOpen);
            document.body.classList.toggle('overflow-hidden', isOpen);
        }

        if (window.innerWidth >= 1024) {
            adminSidebar?.classList.remove('-translate-x-full');
            adminSidebar?.classList.add('translate-x-0');
            adminSidebarBackdrop?.classList.add('opacity-0');
            adminSidebarBackdrop?.classList.add('pointer-events-none');
            adminSidebarBackdrop?.classList.remove('opacity-100');
            document.body.classList.remove('overflow-hidden');
        }

        openMobileSidebar?.addEventListener('click', () => setSidebarOpen(true));
        closeMobileSidebar?.addEventListener('click', () => setSidebarOpen(false));
        adminSidebarBackdrop?.addEventListener('click', () => setSidebarOpen(false));

        window.addEventListener('resize', () => {
            if (window.innerWidth >= 1024) {
                setSidebarOpen(false);
                document.body.classList.remove('overflow-hidden');
            }
        });
    </script>
</body>
</html>
