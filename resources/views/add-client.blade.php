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
                    <h1 class="text-2xl font-semibold ml-4">Add Client</h1>
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
                <div class="dashboard-card w-full max-w-8xl bg-white dark:bg-gray-800 p-8 rounded-xl shadow-lg">
        
      <form id="addClientForm" method="POST" action="{{ url('/add-client') }}">
    @csrf
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
        <div>
            <label for="first_name" class="form-label">First Name</label>
            <input 
                type="text" id="first_name" name="first_name" required
                placeholder="Enter name"
                value="{{ old('first_name') }}"
                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
            />
            @error('first_name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label for="last_name" class="form-label">Last Name</label>
            <input 
                type="text" id="last_name" name="last_name" required
                placeholder="Enter name"
                value="{{ old('last_name') }}"
                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
            />
            @error('last_name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div class="mb-4">
        <label for="phone" class="form-label">Phone</label>
        <input 
            type="tel" id="phone" name="phone" required
            placeholder="e.g., 1234567890"
            maxlength="10"
            value="{{ old('phone') }}"
            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
        />
        @error('phone')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div class="mb-4">
        <label for="email" class="form-label">Email</label>
        <input 
            type="email" id="email" name="email" required
            placeholder="e.g., example@domain.com"
            value="{{ old('email') }}"
            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
        />
        @error('email')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div class="mb-6">
        <label for="remarks" class="form-label">Remarks</label>
        <textarea
            id="remarks"
            name="remarks"
            rows="4"
            maxlength="200"
            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-900 dark:text-white rounded-md resize-y focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400"
        >{{ old('remarks') }}</textarea>
        <p id="remarksCounter" class="text-right text-sm text-gray-500 dark:text-gray-400 mt-1">0/200 characters</p>
        @error('remarks')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div class="flex justify-end space-x-4">
        <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
            Add Client
        </button>
    </div>
</form>


    </div>
                
            </main>

           @include('layouts.footer')
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const phoneInput = document.getElementById('phone');
        const phoneError = document.getElementById('phoneError');
        const emailInput = document.getElementById('email');
        const emailError = document.getElementById('emailError');
        const remarksTextarea = document.getElementById('remarks');
        const remarksCounter = document.getElementById('remarksCounter');
       
        phoneInput.addEventListener('input', function () {
            this.value = this.value.replace(/\D/g, '');
            if (this.value.length !== 10 && this.value.length > 0) {
                phoneError.classList.remove('hidden');
            } else {
                phoneError.classList.add('hidden');
            }
        });

        phoneInput.addEventListener('blur', function () {
            if (this.value.length !== 10 && this.value.length > 0) {
                phoneError.classList.remove('hidden');
            } else {
                phoneError.classList.add('hidden');
            }
        });

        emailInput.addEventListener('blur', function () {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(this.value) && this.value.length > 0) {
                emailError.classList.remove('hidden');
            } else {
                emailError.classList.add('hidden');
            }
        });

        remarksTextarea.addEventListener('input', function () {
            const currentLength = this.value.length;
            remarksCounter.textContent = `${currentLength}/200 characters`;
        });

        // Initialize counter
        remarksTextarea.dispatchEvent(new Event('input'));

    });
</script>
@if(session('client_added'))
<script>
    Swal.fire({
        title: 'Client Added!',
        text: 'What would you like to do next?',
        icon: 'success',
        showCancelButton: true,
        confirmButtonText: 'View Clients',
        cancelButtonText: 'Add More',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = "{{ url('/view-clients') }}";
        }
        
    });
</script>
@endif
   </body>
</html>
