 <!-- Footer -->
            <footer class="footer bg-white dark:bg-gray-800 p-4 text-center text-sm text-gray-600 dark:text-gray-400 rounded-t-xl flex flex-col md:flex-row justify-between items-center">
                <p>&copy; 2025. All Rights Reserved.</p>
                <p class="mt-2 md:mt-0">Developed by <a href="https://spectroit.com" class="text-blue-600 dark:text-blue-400 hover:underline">Spectro Infotech Pvt Ltd</a></p>
            </footer>
        </div>
    </div>
    <!-- Change Password Modal -->
<div id="changePasswordModal" class="fixed inset-0 hidden bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg w-full max-w-md p-6 relative">
        
        <!-- Close Button -->
        <button id="closeChangePasswordModal" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700 dark:text-gray-300 dark:hover:text-white">
            <i class="ri-close-line text-2xl"></i>
        </button>

        <h2 class="text-xl font-semibold mb-4 text-gray-800 dark:text-gray-100">Change Password</h2>
        
        <form id="changePasswordForm" method="POST" action="{{ route('password.change') }}">
            @csrf

            <!-- New Password -->
            <div class="mb-4 relative">
                <label for="new_password" class="block text-sm font-medium mb-1">New Password</label>
                <input type="password" id="new_password" name="new_password" minlength="5" maxlength="20" required
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md 
                           bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500 pr-10">
                <button type="button" class="absolute right-3 top-9 text-gray-500 toggle-password" data-target="new_password">
                    <i class="ri-eye-off-line"></i>
                </button>
            </div>

            <!-- Confirm Password -->
            <div class="mb-4 relative">
                <label for="confirm_password" class="block text-sm font-medium mb-1">Confirm New Password</label>
                <input type="password" id="confirm_password" name="confirm_password" minlength="5" maxlength="20" required
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md 
                           bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500 pr-10">
                <button type="button" class="absolute right-3 top-9 text-gray-500 toggle-password" data-target="confirm_password">
                    <i class="ri-eye-off-line"></i>
                </button>
            </div>

            <!-- Error -->
            <p id="passwordError" class="text-red-500 text-sm hidden mb-3">Passwords do not match.</p>

            <div class="flex justify-end space-x-3">
                <button type="button" id="cancelChangePassword" class="px-4 py-2 rounded-md bg-gray-200 dark:bg-gray-700 dark:text-gray-300 hover:bg-gray-300">
                    Cancel
                </button>
                <button type="submit" class="px-4 py-2 rounded-md bg-blue-600 text-white hover:bg-blue-700">
                    Update Password
                </button>
            </div>
        </form>
    </div>
</div>


    <script src="{{ asset('js/script.js') }}"></script>
   <script>
document.addEventListener("DOMContentLoaded", () => {
    const modal = document.getElementById("changePasswordModal");
    const openBtn = document.getElementById("openChangePasswordModal");
    const closeBtn = document.getElementById("closeChangePasswordModal");
    const cancelBtn = document.getElementById("cancelChangePassword");
    const form = document.getElementById("changePasswordForm");
    const newPassword = document.getElementById("new_password");
    const confirmPassword = document.getElementById("confirm_password");
    const errorText = document.getElementById("passwordError");

    // Open modal
    openBtn.addEventListener("click", () => modal.classList.remove("hidden"));
    
    // Close modal
    [closeBtn, cancelBtn].forEach(btn => {
        btn.addEventListener("click", () => modal.classList.add("hidden"));
    });

    // Password show/hide
    document.querySelectorAll(".toggle-password").forEach(button => {
        button.addEventListener("click", () => {
            const input = document.getElementById(button.dataset.target);
            const icon = button.querySelector("i");
            if (input.type === "password") {
                input.type = "text";
                icon.classList.remove("ri-eye-off-line");
                icon.classList.add("ri-eye-line");
            } else {
                input.type = "password";
                icon.classList.remove("ri-eye-line");
                icon.classList.add("ri-eye-off-line");
            }
        });
    });

    // Validate form
    form.addEventListener("submit", (e) => {
        if (newPassword.value !== confirmPassword.value) {
            e.preventDefault();
            errorText.classList.remove("hidden");
        } else {
            errorText.classList.add("hidden");
        }
    });
});
</script>
@if(session('success'))
    <script>
        Swal.fire({
            title: "Success!",
            text: "{{ session('success') }}",
            icon: "success",
            confirmButtonText: "OK"
        });
    </script>
@endif

@if($errors->any())
    <script>
        Swal.fire({
            title: "Error!",
            html: "{!! implode('<br>', $errors->all()) !!}",
            icon: "error",
            confirmButtonText: "OK"
        });
    </script>
@endif

