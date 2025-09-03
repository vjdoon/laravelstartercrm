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
                    <h1 class="text-2xl font-semibold ml-4">Add User</h1>
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
       
        <form id="addUserForm" action="{{ url('add-user') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-4">
                <div>
                    <label for="username" class="form-label">User Name</label>
                    <input 
  type="text" id="username" name="username" required
  placeholder="Enter username"
  class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
/>
<small id="usernameError" class="text-red-600 text-sm hidden"></small>
                </div>
                <div>
                    <label for="password" class="form-label">Password</label>
                    <input 
  type="password" id="password" name="password" required
  placeholder="Enter password"
  class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
/>
 <small id="passwordError" class="text-red-600 text-sm hidden"></small>
                </div>
                 <div>
    <label for="usertype" class="form-label block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">User Type</label>
    <select 
      id="usertype" name="usertype" required
      class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
    >
      <option value="">Select Type</option>
      <option value="admin">Admin</option>
      <option value="user">User</option>
    </select>
  </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
            
</div>

            <div class="flex justify-end space-x-4">
                
                <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    Add User
                </button>
            </div>
        </form>
    </div>
                
            </main>

          @include('layouts.footer')
          <script>
document.getElementById('username').addEventListener('blur', function() {
    let username = this.value;
    if(username.length > 0) {
        fetch("{{ url('check-username') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({ username: username })
        })
        .then(res => res.json())
        .then(data => {
            if(!data.available) {
                Swal.fire({
                    icon: 'error',
                    title: 'Username Taken',
                    text: 'This username is already registered.'
                });
                document.getElementById('username').value = '';
            }
        });
    }
    let username1 = this.value.trim();
    let errorEl = document.getElementById("usernameError");
    if (username1.length < 4 || username1.length > 50) {
        errorEl.textContent = "Username must be between 4 and 50 characters.";
        errorEl.classList.remove("hidden");
        this.classList.add("border-red-500");
        } else {
            errorEl.textContent = "";
            errorEl.classList.add("hidden");
            this.classList.remove("border-red-500");
        }
    });

    // Password validation
    document.getElementById("password").addEventListener("blur", function() {
        let password = this.value.trim();
        let errorEl = document.getElementById("passwordError");
        if (password.length < 5 || password.length > 20) {
            errorEl.textContent = "Password must be between 5 and 20 characters.";
            errorEl.classList.remove("hidden");
            this.classList.add("border-red-500");
        } else {
            errorEl.textContent = "";
            errorEl.classList.add("hidden");
            this.classList.remove("border-red-500");
        }
    });
</script>
@if(session('success'))
<script>
    Swal.fire({
        title: 'Success!',
        text: '{{ session("success") }}',
        icon: 'success',
        showCancelButton: true,
        confirmButtonText: 'Add More',
        cancelButtonText: 'View Users',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            // OK clicked → close alert
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            // View Users clicked → redirect
            window.location.href = "/view-users";
        }
    });
</script>
@endif
   </body>
</html>
