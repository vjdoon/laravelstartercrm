<!DOCTYPE html>
<html lang="en" class="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login CRM</title>
    <!--<script src="https://cdn.tailwindcss.com"></script>-->@vite('resources/css/app.css')
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet">
    <style>
        .login-card {
            backdrop-filter: blur(10px);
            background-color: rgba(255, 255, 255, 0.9);
        }
        .dark .login-card {
            background-color: rgba(31, 41, 55, 0.9);
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100 min-h-screen flex items-center justify-center">

    <div class="login-card w-full max-w-md p-8 rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700">
        <div class="text-center mb-6">
            <img src="https://placehold.co/60x60/667EEA/ffffff?text=DB" alt="Logo" class="mx-auto mb-2 rounded-full">
            <h2 class="text-2xl font-bold">Howdy!</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">Please login to your dashboard</p>
        </div>

        <form action="#" method="POST" class="space-y-4">
            @csrf
            <div>
                <label for="username" class="block mb-1 text-sm font-medium">Username</label>
                <div class="relative">
                    <i class="ri-user-line absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 dark:text-gray-500"></i>
                    <input type="text" id="username" name="username" placeholder="Enter your username"
                        class="w-full pl-10 pr-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                </div>
            </div>

            <div>
                <label for="password" class="block mb-1 text-sm font-medium">Password</label>
                <div class="relative">
                    <i class="ri-lock-2-line absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 dark:text-gray-500"></i>
                    <input type="password" id="password" name="password" placeholder="Enter your password"
                        class="w-full pl-10 pr-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                </div>
            </div>

            <div class="flex items-center justify-between">
                <label class="flex items-center text-sm">
                    <input type="checkbox" class="form-checkbox h-4 w-4 text-blue-600 border-gray-300 rounded dark:bg-gray-800 dark:border-gray-600">
                    <span class="ml-2">Remember me</span>
                </label>
               <!-- 
                <a href="#" class="text-sm text-blue-600 dark:text-blue-400 hover:underline">Forgot Password?</a>-->
            </div>

            <button type="submit"
                class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition duration-200 shadow-md">
                Login
            </button>
        </form>
    </div>
@if(session('error'))
<script>
    Swal.fire({
        title: "Info",
        text: "{{ session('error') }}",
        icon: "info",
        confirmButtonText: "OK"
    });
</script>
@endif
@if($errors->any())
<script>
    Swal.fire({
        title: "Error",
        text: "{{ $errors->first() }}",
        icon: "error",
        confirmButtonText: "OK"
    });
</script>
@endif
</body>
</html>
