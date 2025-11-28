<?php

use Illuminate\Support\Facades\Session;
use App\Models\Mahasiswa;

$npm = Session::get('npm');
// Retrieve whether this NPM already voted (0 or 1)
$sudah_vote = Mahasiswa::where('npm', $npm)->value('sudah_vote') ?? 0;
$role = Mahasiswa::where('npm', $npm)->value('role');
$nama = Mahasiswa::where('npm', $npm)->value('nama');   
?>
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
        <!-- sidebar -->
        <aside class="hidden bg-red-900 px-3 text-white md:block">
            <div class="px-3 py-5 text-center flex flex-col items-center justify-center">
                        <img src="{{asset('assets/img/logo 2.png')}}" class="w-20" alt="">
                        <span class="text-sm text-red-200">Pemilu Raya Hima Humas</span>
                    </div>
            <div class="p-4 text-center">
                <a href="/vote" class="block rounded-lg bg-red-800 py-3 px-5 font-medium text-white transition-colors hover:bg-red-700">
                    <i class="fas fa-hand-point-up text-xl"></i>
                    <span class="text-xs block">Vote</span>
                </a>
            </div>
            @if($role === 'admin')
            <div class="p-4 text-center">
                <a href="/admin" class="block rounded-lg bg-red-800 py-3 px-5 font-medium text-white transition-colors hover:bg-red-700">
                    <i class="fas fa-user-cog text-xl"></i>
                    <span class="text-xs block">Admin</span>
                </a>
            </div>
            @endif
        </aside>



    <!-- Main Voting Content Area -->
    <div id="main-content" class="relative h-screen flex-1 overflow-y-auto bg-white md:ml-0">
            <!-- Header Placeholder (Matches Admin/Vote style) -->
            <header class="sticky top-0 z-10 flex items-center justify-between border-b bg-white px-4 py-3 shadow-sm md:px-6">
                <!-- Title -->
                <div>
                    <h1 class="text-lg font-semibold text-gray-800">Dashboard - Vote</h1>
                </div>

                <!-- User Dropdown (Logout) -->
                <div class="relative">
                    <div id="user-menu-button" class="flex cursor-pointer items-center space-x-2 rounded-full p-1 pr-2 hover:bg-gray-100" onclick="toggleUserMenu()">
                        <span class=" font-medium text-gray-700 ">{{ $nama }}</span>
                        <i class="fas fa-chevron-down hidden text-xs text-gray-500 md:block"></i>
                    </div>
                    <!-- Dropdown Menu -->
                    <div id="user-menu-dropdown" class="absolute right-0 mt-2 w-48 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 hidden">
                        <div class="py-1" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button">
                            <a href="/logout" class="block px-4 py-2 text-sm font-medium text-red-700 hover:bg-gray-100" role="menuitem">Logout</a>
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
                                @php
                                    $c1 = $voteCounts[1] ?? 0;
                                    $c2 = $voteCounts[2] ?? 0;
                                    $total = $totalVotes ?? ($c1 + $c2);
                                    $p1 = $total > 0 ? round(($c1 / $total) * 100, 2) : 0;
                                @endphp
                                <span class="mb-1 inline-block rounded bg-green-100 px-2 py-0.5 text-xs font-medium text-green-800">{{ $p1 }}%</span>
                                <h3 class="truncate font-semibold text-red-900">Leona Kristin Marbun</h3>
                                <p class="text-2xl font-bold text-gray-900">{{ $c1 }} Vote</p>
                            </div>
                        </div>
                        <!-- Candidate Card 2 -->
                        <div class="flex items-center space-x-4 rounded-lg bg-white px-4 py-6 shadow">
                            <img src="{{ asset('assets/img/candidate 2.jpg') }}" alt="" class="h-16 w-16 flex-shrink-0 rounded-full object-cover md:h-20 md:w-20">
                            <div class="min-w-0">
                                @php $p2 = $total > 0 ? round(($c2 / $total) * 100, 2) : 0; @endphp
                                <span class="mb-1 inline-block rounded bg-green-100 px-2 py-0.5 text-xs font-medium text-green-800">{{ $p2 }}%</span>
                                <h3 class="truncate font-semibold text-red-900">Muhammad Faishal Akmal</h3>
                                <p class="text-2xl font-bold text-gray-900">{{ $c2 }} Vote</p>
                            </div>
                        </div>
                        <!-- Add more candidate cards as needed -->
                    </div>

                    <!-- Data Table -->
                    <div class="overflow-hidden rounded-lg bg-white shadow">
                        <!-- Table Controls -->
                        <div class="flex flex-col items-center justify-between space-y-2 p-4 md:flex-row md:space-y-0">
                            <div class="flex items-center space-x-2">
                                <label for="show-entries" class="text-sm text-gray-600" hidden>Show</label>
                                <select id="show-entries" class="rounded border-gray-300 text-sm focus:border-red-500 focus:ring-red-500" hidden>
                                    <option value="50" selected>50</option>
                                </select>
                                <span class="text-sm text-gray-600" hidden>entries</span>
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
                                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Sudah Vote?</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Pilihan</th>
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
            // Defensive: only toggle if elements exist (this template sometimes omits mobile elements)
            if (sidebar) sidebar.classList.toggle('active');
            if (sidebarOverlay) sidebarOverlay.classList.toggle('hidden');
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
                     if (sidebar) sidebar.classList.remove('active'); // No 'active' class on desktop
                     if (sidebarOverlay) sidebarOverlay.classList.add('hidden');
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

        // Real mahasiswa data injected from server (prepared in DashboardController)
        const allData = @json($mahasiswasForJs ?? []);

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
                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-900">${row.sudah_vote}</td>
                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-900">${row.pilihan}</td>
                        
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
