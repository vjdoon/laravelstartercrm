@include('layouts.header')
<body class="bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100">

    <div class="flex min-h-screen">
        <!-- Sidebar -->
        @include('layouts.sidebar')

        <!-- Main Content Area -->
        <div id="main-content" class="main-content flex-1 ml-0 md:ml-64-desktop flex flex-col">
            <!-- Top Header -->
            <header class="top-header bg-white dark:bg-gray-800 p-4 flex items-center justify-between shadow-md rounded-b-xl">
                <div class="flex items-center">
                    <button id="sidebar-toggle-btn" class="p-2 rounded-full hover:bg-gray-200 dark:hover:bg-gray-700 focus:outline-none">
                        <i class="ri-menu-line text-xl"></i>
                    </button>
                    <h1 class="text-2xl font-semibold ml-4">Dashboard</h1>
                </div>

                <div class="flex items-center space-x-4">
                    <div class="hidden sm:flex items-center text-gray-600 dark:text-gray-300">
                        <i class="ri-dashboard-line mr-1"></i>
                        <span>Dashboard - CRM</span>
                    </div>
                <button id="theme-switch" class="p-2 rounded-full hover:bg-gray-200 dark:hover:bg-gray-700 focus:outline-none">
                        <i class="ri-sun-line text-xl dark:hidden"></i>
                        <i class="ri-moon-line text-xl hidden dark:block"></i>
                    </button>

                    <div class="relative">
                        <img id="account-avatar" src="https://placehold.co/40x40/3B82F6/ffffff?text=U" alt="User Avatar" class="w-10 h-10 rounded-full cursor-pointer border-2 border-blue-500">
                        <div id="account-dropdown" class="dropdown-menu absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-md shadow-lg py-1 hidden z-10">
                            <button id="openChangePasswordModal" type="button" 
    class="w-full text-left block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 
           hover:bg-gray-100 dark:hover:bg-gray-700 rounded-t-md">
    <i class="ri-lock-line mr-2"></i> Change Password
</button>
                          <form action="{{ route('logout') }}" method="POST">
    @csrf
    <button type="submit" class="w-full text-left block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-b-md">
        <i class="ri-logout-box-line mr-2"></i> Logout
    </button>
</form>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Dashboard Content -->
            <main class="p-6 flex-grow">
                <!-- Summary Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                    <!-- Total Clients Card -->
                    <!-- Total Users Card -->
<div class="dashboard-card bg-white dark:bg-gray-800 p-6 rounded-xl shadow-md flex items-center">
    <div class="bg-blue-100 text-blue-600 dark:bg-blue-900 dark:text-blue-300 p-3 rounded-full mr-4">
        <i class="ri-group-line text-2xl"></i>
    </div>
    <div>
        <p class="text-sm text-gray-500 dark:text-gray-400">Total Users</p>
        <p class="text-3xl font-bold mt-1">{{ $totalUsers }}</p>
        <p class="text-xs text-green-500 mt-1">
            <i class="ri-arrow-up-line"></i> +{{ $weeklyUsers }} <span class="text-gray-500 dark:text-gray-400">this week</span>
        </p>
    </div>
</div>


                    <!-- Card 2 -->
                    <div class="dashboard-card bg-white dark:bg-gray-800 p-6 rounded-xl shadow-md flex items-center">
                        <div class="bg-green-100 text-green-600 dark:bg-green-900 dark:text-green-300 p-3 rounded-full mr-4">
                            <i class="ri-car-line text-2xl"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Card 2</p>
                            <p class="text-3xl font-bold mt-1">6</p>
                            <p class="text-xs text-green-500 mt-1">
                                <i class="ri-arrow-up-line"></i> +0 <span class="text-gray-500 dark:text-gray-400">this week</span>
                            </p>
                        </div>
                    </div>

                    <!-- Card 3 -->
                    <div class="dashboard-card bg-white dark:bg-gray-800 p-6 rounded-xl shadow-md flex items-center">
                        <div class="bg-yellow-100 text-yellow-600 dark:bg-yellow-900 dark:text-yellow-300 p-3 rounded-full mr-4">
                            <i class="ri-wallet-line text-2xl"></i>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Card 3</p>
                            <p class="text-3xl font-bold mt-1">₹0</p>
                            <p class="text-xs text-green-500 mt-1">
                                <i class="ri-arrow-up-line"></i> +0 <span class="text-gray-500 dark:text-gray-400">this week</span>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Two column cards -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Card 4 -->
                    <div class="table-card bg-white dark:bg-gray-800 p-6 rounded-xl shadow-md">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold">Card 4</h3>
                            <a href="#" class="text-blue-600 dark:text-blue-400 text-sm font-medium hover:underline">View All</a>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider rounded-tl-lg">Heading 1</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Heading 2</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Heading 3</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider rounded-tr-lg">Heading 4</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    <tr>
                                        <td colspan="4" class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-500 dark:text-gray-400">
                                            No table content.
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Card 5 -->
                    <div class="table-card bg-white dark:bg-gray-800 p-6 rounded-xl shadow-md">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold">Card 5</h3>
                            <a href="#" class="text-blue-600 dark:text-blue-400 text-sm font-medium hover:underline">View All</a>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                         <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider rounded-tl-lg">Heading 1</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Heading 2</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Heading 3</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider rounded-tr-lg">Heading 4</th></tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-500 dark:text-gray-400">
                                            No table content.
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>

            <!-- Footer -->
          @include('layouts.footer')
   </body>
</html>
