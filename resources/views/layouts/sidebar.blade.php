@php
    // Get the current URL path
    $currentPath = Request::path();
@endphp

@php
    // Get the current URL path
    $currentPath = Request::path();
@endphp

<aside id="sidebar" class="sidebar w-64 bg-white dark:bg-gray-800 fixed h-full flex flex-col rounded-r-xl z-20 overflow-y-auto no-scrollbar">
    <div class="p-4 flex items-center justify-between border-b border-gray-200 dark:border-gray-700">
        <div class="flex items-center">
            <img src="https://placehold.co/40x40/667EEA/ffffff?text=DB" alt="Dashboard Logo" class="rounded-full mr-2">
            <span class="text-xl font-bold sidebar-item-text">Dash</span>
        </div>
        <button id="sidebar-close-btn" class="md:hidden p-2 rounded-full hover:bg-gray-200 dark:hover:bg-gray-700 focus:outline-none">
            <i class="ri-close-line text-xl"></i>
        </button>
    </div>

    <nav class="mt-4 flex-grow">
        <ul>
            <li class="mb-2">
                <a href="{{ url('dashboard') }}" class="sidebar-item flex items-center p-3 mx-3 rounded-xl {{ $currentPath == 'dashboard' ? 'bg-blue-600 text-white shadow-md' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                    <i class="ri-dashboard-line text-lg mr-3"></i>
                    <span class="sidebar-item-text">Dashboard</span>
                </a>
            </li>
            <li class="px-6 py-2 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase sidebar-item-text">Application</li>

            <li class="mb-2 accordion-item {{ Str::startsWith($currentPath, 'client') ? 'active-accordion' : '' }}">
                <a href="#" class="sidebar-item flex items-center justify-between p-3 mx-3 rounded-xl {{ Str::startsWith($currentPath, 'client') ? 'bg-blue-600 text-white shadow-md' : 'hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer' }}">
                    <div class="flex items-center">
                        <i class="ri-group-line text-lg mr-3"></i>
                        <span class="sidebar-item-text">Clients</span>
                    </div>
                    <i class="ri-arrow-right-s-line text-lg accordion-icon"></i>
                </a>
                <ul class="submenu-items accordion-content ml-10 mt-1">
                    <li><a href="{{ url('add-client') }}" class="block p-2 text-sm rounded-lg {{ $currentPath == 'add-client' ? 'bg-blue-600 text-white' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }}">Add New Client</a></li>
                    <li><a href="{{ url('view-clients') }}" class="block p-2 text-sm rounded-lg {{ $currentPath == 'view-clients' || Str::startsWith($currentPath, 'edit-client') ? 'bg-blue-600 text-white' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }}">View Clients</a></li>
                </ul>
            </li>

            <li class="mb-2 accordion-item {{ Str::startsWith($currentPath, 'user') ? 'active-accordion' : '' }}">
                <a href="#" class="sidebar-item flex items-center justify-between p-3 mx-3 rounded-xl {{ Str::startsWith($currentPath, 'user') ? 'bg-blue-600 text-white shadow-md' : 'hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer' }}">
                    <div class="flex items-center">
                        <i class="ri-group-line text-lg mr-3"></i>
                        <span class="sidebar-item-text">Users</span>
                    </div>
                    <i class="ri-arrow-right-s-line text-lg accordion-icon"></i>
                </a>
                <ul class="submenu-items accordion-content ml-10 mt-1">
                    <li><a href="{{ url('add-user') }}" class="block p-2 text-sm rounded-lg {{ $currentPath == 'add-user' ? 'bg-blue-600 text-white' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }}">Add User</a></li>
                    <li><a href="{{ url('view-users') }}" class="block p-2 text-sm rounded-lg {{ $currentPath == 'view-users' || Str::startsWith($currentPath, 'edit-user') ? 'bg-blue-600 text-white' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }}">View Users</a></li>
                </ul>
            </li>

            <li class="mb-2">
                <a href="#" class="sidebar-item flex items-center p-3 mx-3 rounded-xl hover:bg-gray-100 dark:hover:bg-gray-700">
                    <i class="ri-file-list-line text-lg mr-3"></i>
                    <span class="sidebar-item-text">Menu Item 1</span>
                </a>
            </li>
            <li class="mb-2">
                <a href="#" class="sidebar-item flex items-center p-3 mx-3 rounded-xl hover:bg-gray-100 dark:hover:bg-gray-700">
                    <i class="ri-file-list-line text-lg mr-3"></i>
                    <span class="sidebar-item-text">Menu Item 2</span>
                </a>
            </li>
        </ul>
    </nav>
</aside>
