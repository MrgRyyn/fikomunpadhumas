<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Use Blade for title, if desired, otherwise use a static title -->
    <title>Admin - Data Vote | {{ config('app.name', 'Pemilu Raya') }}</title>

    <!-- 1. SOLUTION: Use CDNs if you are NOT running 'npm run dev' with Vite. -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100">

    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar (Removed redundant class 'fixed z-30' as md:translate-x-0 handles desktop) -->
        <aside id="sidebar" class="fixed z-30 h-full w-64 -translate-x-full bg-red-900 text-white shadow-lg md:translate-x-0">
            <div class="flex h-full flex-col justify-between">
                <div>
                    <!-- Logo/Title Area -->
                    <div class="p-6 text-center">
                        <h2 class="text-2xl font-bold text-white">Admin Panel</h2>
                        <span class="text-sm text-red-200">Pemilu Raya Hima Humas</span>
                    </div>
                    <!-- Navigation -->
                    <nav class="mt-6">
                        <ul class="space-y-1 px-4">
                            <li>
                                <a id="nav-data-vote" href="#" class="nav-link active" onclick="showPage('page-data-vote', 'Data Vote')">
                                    <i class="fas fa-chart-pie mr-3 w-5 text-center"></i>
                                    Data Vote
                                </a>
                            </li>
                            <li>
                                <a id="nav-manage-users" href="#" class="nav-link" onclick="showPage('page-manage-users', 'Manage Users')">
                                    <i class="fas fa-users mr-3 w-5 text-center"></i>
                                    Manage Users
                                </a>
                            </li>
                            <li>
                                <a id="nav-candidates" href="#" class="nav-link" onclick="showPage('page-candidates', 'Candidates')">
                                    <i class="fas fa-user-tie mr-3 w-5 text-center"></i>
                                    Candidates
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
                <!-- Logout Button at bottom -->
                <div class="p-4">
                     <a href="#" class="nav-link">
                        <i class="fas fa-sign-out-alt mr-3 w-5 text-center"></i>
                        Logout
                    </a>
                </div>
            </div>
        </aside>

        <!-- Overlay for mobile when sidebar is open -->
        <div id="sidebar-overlay" class="fixed inset-0 z-20 hidden bg-black/50 md:hidden" onclick="toggleSidebar()"></div>

        <!-- main content -->
        <div id="main-content" class="relative h-screen flex-1 overflow-y-auto md:ml-64">
            <!-- Header -->
            <header class="sticky top-0 z-10 flex items-center justify-between border-b bg-white px-4 py-3 shadow-sm md:px-6">
                <!-- Hamburger Menu (Mobile) -->
                <button id="sidebar-toggle" class="text-gray-600 md:hidden" onclick="toggleSidebar()">
                    <i class="fas fa-bars text-xl"></i>
                </button>

                <!-- Page Title -->
                <div>
                    <h1 id="header-title" class="text-lg font-semibold text-gray-800">Data Vote</h1>
                </div>

                <!-- User Dropdown -->
                <div class="relative">
                    <div id="user-menu-button" class="flex cursor-pointer items-center space-x-2 rounded-full p-1 pr-2 hover:bg-gray-100" onclick="toggleUserMenu()">
                        <img src="{{ asset ('assets/img/user profile.webp') }}" alt="User Avatar" class="h-8 w-8 rounded-full">
                        <span class="hidden font-medium text-gray-700 md:block">User</span>
                        <i class="fas fa-chevron-down hidden text-xs text-gray-500 md:block"></i>
                    </div>
                    <!-- Dropdown Menu -->
                    <div id="user-menu-dropdown" class="absolute right-0 mt-2 w-48 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 hidden">
                        <div class="py-1" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button">
                            <a href="#" class="block px-4 py-2 text-sm font-medium text-red-700 hover:bg-gray-100" role="menuitem">Logout</a>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="p-4 md:p-6">

                <!-- Page: Data Vote -->
                <div id="page-data-vote" class="page-content">
                    <!-- Title -->
                    <h1 class="mb-4 text-2xl font-bold text-gray-800">Data Vote</h1>

                    <!-- Stats Cards -->
                    <div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                        <!-- Candidate Card 1 -->
                        <div class="flex items-center space-x-4 rounded-lg bg-white px-4 py-6 shadow">
                            <img src="{{ asset('assets/img/candidate 1.jpg') }}" alt="" class="h-16 w-16 flex-shrink-0 rounded-full object-cover md:h-20 md:w-20">
                            <div class="min-w-0">
                                <span class="mb-1 inline-block rounded bg-green-100 px-2 py-0.5 text-xs font-medium text-green-800">2.69%</span>
                                <h3 class="truncate font-semibold text-red-900">Leona Kristin Marbun</h3>
                                <p class="text-2xl font-bold text-gray-900">xxx Vote</p>
                            </div>
                        </div>
                        <!-- Candidate Card 2 -->
                        <div class="flex items-center space-x-4 rounded-lg bg-white px-4 py-6 shadow">
                            <img src="{{ asset('assets/img/candidate 2.jpg') }}" alt="" class="h-16 w-16 flex-shrink-0 rounded-full object-cover md:h-20 md:w-20">
                            <div class="min-w-0">
                                <span class="mb-1 inline-block rounded bg-green-100 px-2 py-0.5 text-xs font-medium text-green-800">3.69%</span>
                                <h3 class="truncate font-semibold text-red-900">Muhammad Faishal Akmal</h3>
                                <p class="text-2xl font-bold text-gray-900">xxx Vote</t>
                            </div>
                        </div>
                        <!-- Add more candidate cards as needed -->
                    </div>

                    <!-- Data Table -->
                    <div class="overflow-hidden rounded-lg bg-white shadow">
                        <!-- Table Controls -->
                        <div class="flex flex-col items-center justify-between space-y-2 p-4 md:flex-row md:space-y-0">
                            <div class="flex items-center space-x-2">
                                <label for="show-entries" class="text-sm text-gray-600">Show</label>
                                <select id="show-entries" class="rounded border-gray-300 text-sm focus:border-red-500 focus:ring-red-500">
                                    <option value="5">5</option>
                                    <option value="10" selected>10</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                </select>
                                <span class="text-sm text-gray-600">entries</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <label for="search" class="text-sm text-gray-600">Search:</label>
                                <input type="text" id="search" class="w-full rounded border-gray-200 border-2 text-sm md:w-auto focus:border-red-500 focus:ring-red-500">
                            </div>
                        </div>

                        <!-- Table -->
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">No.</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">NIM</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Nama</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Email</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Pilihan</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="data-table-body" class="divide-y divide-gray-200 bg-white">
                                    <!-- Rows will be injected by JavaScript -->
                                </tbody>
                            </table>
                        </div>

                        <!-- Table Footer / Pagination -->
                        <div class="flex flex-col items-center justify-between space-y-2 p-4 md:flex-row md:space-y-0">
                            <div id="pagination-info" class="text-sm text-gray-600">
                                Showing 1 to 10 of 30 entries
                            </div>
                            <div class="flex items-center space-x-1">
                                <button id="btn-prev" class="rounded border border-gray-300 px-3 py-1 text-sm text-gray-700 hover:bg-gray-100 disabled:opacity-50 disabled:cursor-not-allowed">
                                    Previous
                                </button>
                                <div id="pagination-numbers" class="flex items-center space-x-1">
                                    <!-- Page numbers will be injected by JavaScript -->
                                </div>
                                <button id="btn-next" class="rounded border border-gray-300 px-3 py-1 text-sm text-gray-700 hover:bg-gray-100 disabled:opacity-50 disabled:cursor-not-allowed">
                                    Next
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Page: Manage Users -->
                <div id="page-manage-users" class="page-content hidden">
                    <h1 class="mb-4 text-2xl font-bold text-gray-800">Manage Users</h1>
                    <div class="rounded-lg bg-white p-6 shadow">
                        <p>This is the Manage Users page. Content goes here.</p>
                    </div>
                </div>

                <!-- Page: Candidates -->
                <div id="page-candidates" class="page-content hidden">
                    <h1 class="mb-4 text-2xl font-bold text-gray-800">Candidates</h1>
                    <div class="rounded-lg bg-white p-6 shadow">
                        <p>This is the Candidates page. Content goes here.</p>
                    </div>
                </div>


            </main>
        </div>
    </div>

    <script>
        // --- Sidebar & User Menu UI ---
        const sidebar = document.getElementById('sidebar');
        const sidebarToggle = document.getElementById('sidebar-toggle');
        const sidebarOverlay = document.getElementById('sidebar-overlay');
        const userMenuButton = document.getElementById('user-menu-button');
        const userMenuDropdown = document.getElementById('user-menu-dropdown');
        const allPages = document.querySelectorAll('.page-content');
        const allNavLinks = document.querySelectorAll('.nav-link');
        const headerTitle = document.getElementById('header-title');

        // Function to toggle the sidebar (mobile only)
        function toggleSidebar() {
            sidebar.classList.toggle('active');
            sidebarOverlay.classList.toggle('hidden');
        }

        // Function to toggle the user menu
        function toggleUserMenu() {
            userMenuDropdown.classList.toggle('hidden');
        }

        // Close user menu if clicking outside
        window.onclick = function(event) {
            if (userMenuButton && !userMenuButton.contains(event.target) && userMenuDropdown && !userMenuDropdown.contains(event.target)) {
                userMenuDropdown.classList.add('hidden');
            }
        }

        // Handle window resize to hide mobile overlay
        window.onresize = () => {
             if (window.innerWidth >= 768) { // md breakpoint
                sidebar.classList.remove('active'); // No 'active' class on desktop
                sidebarOverlay.classList.add('hidden');
             }
        };

        // --- Page Navigation ---
        function showPage(pageId, title) {
            // Hide all pages
            allPages.forEach(page => {
                page.classList.add('hidden');
            });
            // Show the selected page
            const activePage = document.getElementById(pageId);
            if (activePage) {
                activePage.classList.remove('hidden');
            }

            // Update header title
            if (headerTitle) {
                headerTitle.innerText = title;
            }

            // Update active state for nav links
            allNavLinks.forEach(link => {
                link.classList.remove('active');
            });
            const navLinkId = 'nav-' + pageId.substring(5);
            const activeLink = document.getElementById(navLinkId);
            if (activeLink) {
                activeLink.classList.add('active');
            }

            // Close sidebar on mobile after navigation
            if (window.innerWidth < 768) {
                toggleSidebar();
            }
        }

        // --- Data Table & Pagination ---

        // Dummy data
        const allData = Array.from({ length: 34 }, (_, i) => {
            const id = i + 1;
            const nim = 12108400 + id;
            const names = ['Anne', 'Budi', 'Citra', 'Doni', 'Eka', 'Fajar', 'Gita'];
            const name = names[i % names.length] + ' ' + (id);
            const email = `${names[i % names.length].toLowerCase()}${id}@gmail.com`;
            const pilihan = (i % 2) + 1; // Randomly 1 or 2
            return { id, nim, nama: name, email, pilihan };
        });

        // Pagination state
        let currentPage = 1;
        let entriesPerPage = 10;
        let currentViewData = [...allData];

        // DOM elements for table
        const tableBody = document.getElementById('data-table-body');
        const searchInput = document.getElementById('search');
        const entriesSelect = document.getElementById('show-entries');
        const paginationInfo = document.getElementById('pagination-info');
        const btnPrev = document.getElementById('btn-prev');
        const btnNext = document.getElementById('btn-next');
        const paginationNumbers = document.getElementById('pagination-numbers');

        function renderTable() {
            if (!tableBody) return; // Exit if table elements aren't on the page

            // Calculate pagination
            const totalEntries = currentViewData.length;
            const totalPages = Math.ceil(totalEntries / entriesPerPage);
            currentPage = Math.max(1, Math.min(currentPage, totalPages)); // Ensure current page is valid

            const start = (currentPage - 1) * entriesPerPage;
            const end = Math.min(start + entriesPerPage, totalEntries);
            const paginatedData = currentViewData.slice(start, end);

            // Render table rows
            tableBody.innerHTML = paginatedData.map((row, index) => {
                return `
                    <tr>
                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-900">${start + index + 1}</td>
                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-900">${row.nim}</td>
                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-900">${row.nama}</td>
                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-900">${row.email}</td>
                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-900">${row.pilihan}</td>
                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">
                            <button class="rounded-full p-2 hover:bg-gray-100">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                        </td>
                    </tr>
                `;
            }).join('');

            // Update pagination info
            if (paginationInfo) {
                if (totalEntries === 0) {
                    paginationInfo.innerText = "No entries found";
                } else {
                    paginationInfo.innerText = `Showing ${start + 1} to ${end} of ${totalEntries} entries`;
                }
            }

            // Update pagination buttons state
            if (btnPrev) btnPrev.disabled = (currentPage === 1);
            if (btnNext) btnNext.disabled = (currentPage === totalPages || totalEntries === 0);

            // Render page numbers
            if (paginationNumbers) {
                paginationNumbers.innerHTML = '';
                for (let i = 1; i <= totalPages; i++) {
                    const pageButton = document.createElement('button');
                    pageButton.innerText = i;
                    pageButton.className = `rounded border px-3 py-1 text-sm ${
                        i === currentPage
                        ? 'border-red-500 bg-red-900 text-white'
                        : 'border-gray-300 text-gray-700 hover:bg-gray-100'
                    }`;
                    pageButton.onclick = () => {
                        currentPage = i;
                        renderTable();
                    };
                    paginationNumbers.appendChild(pageButton);
                }
            }
        }

        // --- Event Listeners ---
        document.addEventListener('DOMContentLoaded', () => {
            // Initial render
            if (document.getElementById('page-data-vote')) {
                entriesPerPage = parseInt(entriesSelect.value, 10);
                renderTable();
            }

            // Entries dropdown
            if (entriesSelect) {
                entriesSelect.addEventListener('change', (e) => {
                    entriesPerPage = parseInt(e.target.value, 10);
                    currentPage = 1;
                    renderTable();
                });
            }

            // Search input
            if (searchInput) {
                searchInput.addEventListener('keyup', (e) => {
                    const searchTerm = e.target.value.toLowerCase();
                    currentViewData = allData.filter(row =>
                        row.nama.toLowerCase().includes(searchTerm) ||
                        row.nim.toString().includes(searchTerm) ||
                        row.email.toLowerCase().includes(searchTerm)
                    );
                    currentPage = 1;
                    renderTable();
                });
            }

            // Pagination buttons
            if (btnPrev) {
                btnPrev.addEventListener('click', () => {
                    if (currentPage > 1) {
                        currentPage--;
                        renderTable();
                    }
                });
            }

            if (btnNext) {
                btnNext.addEventListener('click', () => {
                    const totalPages = Math.ceil(currentViewData.length / entriesPerPage);
                    if (currentPage < totalPages) {
                        currentPage++;
                        renderTable();
                    }
                });
            }
        });
    </script>
</body>
</html>
