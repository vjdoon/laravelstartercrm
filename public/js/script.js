  const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('main-content');
        const sidebarToggleBtn = document.getElementById('sidebar-toggle-btn');
        const sidebarCloseBtn = document.getElementById('sidebar-close-btn'); // New close button
        const themeSwitch = document.getElementById('theme-switch');
        const accountAvatar = document.getElementById('account-avatar');
        const accountDropdown = document.getElementById('account-dropdown');
        const accordionItems = document.querySelectorAll('.accordion-item');

        // Initialize theme from localStorage
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
            document.documentElement.classList.remove('light');
        } else {
            document.documentElement.classList.remove('dark');
            document.documentElement.classList.add('light');
        }

        // Function to update main content margin based on sidebar state and screen size
        const updateMainContentMargin = () => {
            if (window.innerWidth >= 768) { // Desktop view
                mainContent.classList.remove('ml-0'); // Ensure ml-0 is removed
                if (sidebar.classList.contains('collapsed')) {
                    mainContent.classList.remove('ml-64-desktop');
                    mainContent.classList.add('ml-20-desktop'); // 80px
                } else {
                    mainContent.classList.remove('ml-20-desktop');
                    mainContent.classList.add('ml-64-desktop'); // 256px
                }
            } else { // Mobile view
                mainContent.classList.remove('ml-20-desktop', 'ml-64-desktop');
                mainContent.classList.add('ml-0'); // Sidebar overlays on mobile
            }
        };

        // Sidebar Toggle Functionality
        const toggleSidebar = () => {
            sidebar.classList.toggle('collapsed');
            updateMainContentMargin();
        };

        // Event listener for the main toggle button (hamburger)
        sidebarToggleBtn.addEventListener('click', toggleSidebar);

        // Event listener for the new mobile close button (X)
        sidebarCloseBtn.addEventListener('click', toggleSidebar);

        // Initial setup on page load
        if (window.innerWidth < 768) { // Mobile default: sidebar collapsed (hidden)
            sidebar.classList.add('collapsed');
        } else { // Desktop default: sidebar expanded
            sidebar.classList.remove('collapsed');
        }
        updateMainContentMargin(); // Set initial margin for main content

        // Adjust sidebar and main content on window resize
        window.addEventListener('resize', () => {
            if (window.innerWidth < 768) { // When resizing to mobile
                sidebar.classList.add('collapsed'); // Hide sidebar
            } else { // When resizing to desktop
                sidebar.classList.remove('collapsed'); // Show expanded sidebar
            }
            updateMainContentMargin(); // Update margin
        });

        
        // Accordion Functionality
accordionItems.forEach(item => {
    const header = item.querySelector('.sidebar-item');
    const content = item.querySelector('.accordion-content');

    // **NEW: Check for active class on page load and open the accordion**
    const isActive = item.classList.contains('active-accordion');
    if (isActive) {
        item.classList.add('active');
        content.classList.add('open');
        content.style.maxHeight = content.scrollHeight + "px";
    }

    header.addEventListener('click', (e) => {
        e.preventDefault(); // Prevent default link behavior
        
        // Close other open accordions
        accordionItems.forEach(otherItem => {
            if (otherItem !== item && otherItem.classList.contains('active')) {
                otherItem.classList.remove('active');
                otherItem.querySelector('.accordion-content').classList.remove('open');
                otherItem.querySelector('.accordion-content').style.maxHeight = null;
            }
        });

        // Toggle the current accordion
        item.classList.toggle('active');
        if (content.classList.contains('open')) {
            content.classList.remove('open');
            content.style.maxHeight = null;
        } else {
            content.classList.add('open');
            content.style.maxHeight = content.scrollHeight + "px";
        }
    });
});
// Open accordion if current page link is inside it
accordionItems.forEach(item => {
    const links = item.querySelectorAll('.accordion-content a');
    links.forEach(link => {
        if (link.href === window.location.href || link.classList.contains('active')) {
            item.classList.add('active');
            const content = item.querySelector('.accordion-content');
            content.classList.add('open');
            content.style.maxHeight = content.scrollHeight + "px"; // expand
        }
    });
});
        // Theme Switch Functionality
        themeSwitch.addEventListener('click', () => {
            if (document.documentElement.classList.contains('dark')) {
                document.documentElement.classList.remove('dark');
                document.documentElement.classList.add('light');
                localStorage.theme = 'light';
            } else {
                document.documentElement.classList.remove('light');
                document.documentElement.classList.add('dark');
                localStorage.theme = 'dark';
            }
        });

        // Account Dropdown Functionality
        accountAvatar.addEventListener('click', () => {
            accountDropdown.classList.toggle('hidden');
        });

        // Close dropdown if clicked outside
        window.addEventListener('click', (e) => {
            if (!accountAvatar.contains(e.target) && !accountDropdown.contains(e.target)) {
                accountDropdown.classList.add('hidden');
            }
        });