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
    <title>Vote Hima Humas | {{ config('app.name', 'Pemilu Raya') }}</title>

    <!-- 1. SOLUTION: Use CDNs if you are NOT running 'npm run dev' with Vite. -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- Assuming you are using Vite, but the script still relies on inline styles -->
    @vite('resources/css/app.css')
    <meta name="csrf-token" content="{{ csrf_token() }}">


</head>
<body class="maroon-bg">

    <div class="flex">

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
        <div id="main-content" class="relative flex-1 bg-white md:ml-0">
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

            <!-- Voting Cards Section -->
            <main class="min-h-screen p-4 md:p-12">
                <h2 class="mb-8 text-3xl font-bold text-gray-800">Vote</h2>

                <div class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:gap-12">

                    <!-- Candidate 1 Card -->
                    <div id="candidate-1" class="candidate-card rounded-xl border-4 border-transparent bg-gray-50 p-6 text-center shadow-lg transition-all duration-300 hover:shadow-xl">
                        <img src="{{asset('assets/img/candidate 1.jpg')}}" alt="Leona Kristin Marbun" class="mx-auto mb-4 h-36 w-36 rounded-full border-4 border-red-900 object-cover">
                        <h3 class="text-2xl font-bold text-gray-800">Leona Kristin Marbun</h3>
                        <p class="mb-4 text-lg font-medium text-gray-600">Nomor Urut 1</p>

                        <button onclick="openVisiMisiModal(1)" class="mb-4 rounded-lg border-2 border-red-900 px-6 py-2 text-sm font-semibold text-red-900 transition-colors hover:bg-red-100">
                            VISI MISI
                        </button>
                    </div>

                    <!-- Candidate 2 Card -->
                    <div id="candidate-2" class="candidate-card rounded-xl border-4 border-transparent bg-gray-50 p-6 text-center shadow-lg transition-all duration-300 hover:shadow-xl">
                        <!-- Generic Icon Placeholder matching video -->
                        <img src="{{asset('assets/img/candidate 2.jpg')}}" alt="Muhammad Faishal Akmal" class="mx-auto mb-4 h-36 w-36 rounded-full border-4 border-red-900 object-cover">
                        <h3 class="text-2xl font-bold text-gray-800">Muhammad Faishal Akmal</h3>
                        <p class="mb-4 text-lg font-medium text-gray-600">Nomor Urut 2</p>

                        <button onclick="openVisiMisiModal(2)" class="mb-4 rounded-lg border-2 border-red-900 px-6 py-2 text-sm font-semibold text-red-900 transition-colors hover:bg-red-100">
                            VISI MISI
                        </button>
                    </div>
                </div>

                <!-- Vote Button -->
                <div class="mt-12 text-center">
                    <button id="vote-sekarang-btn" onclick="openConfirmationModal()" class="yellow-btn rounded-lg px-12 py-4 text-xl font-bold shadow-xl disabled:opacity-50 disabled:cursor-not-allowed">
                        Vote Sekarang!
                    </button>
                </div>
            </main>
        </div>
    </div>

    <!-- 1. Visi Misi Modal (Video + Text) -->
    <div id="visi-misi-modal" class="modal-backdrop fixed inset-0 z-50 hidden items-center justify-center overflow-y-auto p-4" onclick="closeVisiMisiModal(event)">
        <div class="w-full max-w-2xl mt-28 transform overflow-hidden rounded-xl bg-white p-6 text-left align-middle shadow-xl transition-all" onclick="event.stopPropagation()">
            <div class="flex items-center justify-between border-b pb-3">
                <h3 id="visi-misi-title" class="text-2xl font-bold text-gray-800">Visi Misi Calon</h3>
                <button type="button" class="text-gray-400 hover:text-gray-600" onclick="closeVisiMisiModal()">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <div class="mt-4">
                <!-- Video Placeholder - Note the new IDs for dynamic updates -->
                <div class="video-container">
                    <video id="visi-misi-video" controls>
                        <!-- MP4 source (primary/fallback) -->
                        <source id="video-source-mp4" src="" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                </div>

                <!-- Visi & Misi Content -->
                <div id="visi-misi-content" class="max-h-96 overflow-y-auto pr-2">
                    <!-- Content will be populated by JS -->
                </div>
            </div>

            <div class="mt-6 border-t pt-4 text-right">
                <button type="button" class="rounded-lg bg-red-700 px-6 py-2 font-semibold text-white hover:bg-red-800" onclick="closeVisiMisiModal()">
                    Close
                </button>
            </div>
        </div>
    </div>

    <!-- 2. Vote Confirmation Modal (Candidate Selection) -->
    <div id="confirmation-modal" class="modal-backdrop fixed inset-0 z-50 hidden items-center justify-center overflow-y-auto p-4" onclick="closeConfirmationModal(event)">
        <div class="w-full max-w-4xl transform overflow-hidden rounded-xl bg-white p-6 text-left align-middle shadow-xl transition-all" onclick="event.stopPropagation()">
            <h3 class="border-b pb-3 text-2xl font-bold text-gray-800">Pilih Kandidat</h3>

            <div class="mt-4 grid grid-cols-2 gap-6">
                <!-- Candidate 1 Selection Card -->
                <div id="select-candidate-1" class="cursor-pointer rounded-xl border-4 border-gray-200 p-4 text-center transition-all duration-200 hover:border-yellow-500" onclick="selectCandidate(1, this)">
                    <img src="{{asset('assets/img/candidate 1.jpg')}}" alt="Candidate 1" class="mx-auto mb-3 h-24 w-24 rounded-full border-2 border-red-900 object-cover md:h-32 md:w-32">
                    <h4 class="text-lg font-semibold text-gray-800">Leona Kristin Marbun</h4>
                </div>

                <!-- Candidate 2 Selection Card -->
                <div id="select-candidate-2" class="cursor-pointer rounded-xl border-4 border-gray-200 p-4 text-center transition-all duration-200 hover:border-yellow-500" onclick="selectCandidate(2, this)">
                    <img src="{{asset('assets/img/candidate 2.jpg')}}" alt="Candidate 2" class="mx-auto mb-3 h-24 w-24 rounded-full border-2 border-red-900 object-cover md:h-32 md:w-32">
                    <h4 class="text-lg font-semibold text-gray-800">Muhammad Faishal Akmal</h4>
                </div>
            </div>

            <p id="selection-error" class="mt-4 text-center text-sm font-medium text-red-600 hidden">Pilih salah satu kandidat sebelum melakukan vote.</p>

            <div class="mt-6 flex justify-end space-x-4 border-t pt-4">
                <button type="button" class="rounded-lg border border-gray-300 px-6 py-2 font-semibold text-gray-700 hover:bg-gray-100" onclick="closeConfirmationModal()">
                    Close
                </button>
                <button id="final-vote-btn" type="button" class="rounded-lg bg-red-700 px-6 py-2 font-semibold text-white hover:bg-red-800 disabled:opacity-50 disabled:cursor-not-allowed" disabled onclick="processVote()">
                    Vote
                </button>
            </div>
        </div>
    </div>

    <!-- 3. Success Modal (After Voting) -->
    <div id="success-modal" class="modal-backdrop fixed inset-0 z-50 hidden items-center justify-center p-4">
        <div class="w-full max-w-sm transform overflow-hidden rounded-xl bg-white p-6 text-center align-middle shadow-xl">
            <div class="mx-auto mb-4 flex h-20 w-20 items-center justify-center rounded-full bg-green-100">
                <i class="fas fa-check text-4xl text-green-600"></i>
            </div>
            <h3 class="mb-2 text-2xl font-bold text-gray-800">Berhasil</h3>
            <p class="mb-6 text-gray-600">Vote anda berhasil dikirim!</p>

            <button type="button" class="rounded-lg bg-red-700 px-8 py-3 font-bold text-white hover:bg-red-800" onclick="closeSuccessModal()">
                OK
            </button>
        </div>
    </div>


    <script>
        const visiMisiModal = document.getElementById('visi-misi-modal');
        const confirmationModal = document.getElementById('confirmation-modal');
        const successModal = document.getElementById('success-modal');
        const visiMisiTitle = document.getElementById('visi-misi-title');
        const visiMisiContent = document.getElementById('visi-misi-content');
        const finalVoteBtn = document.getElementById('final-vote-btn');
        const selectionError = document.getElementById('selection-error');
        const userMenuButton = document.getElementById('user-menu-button');
        const userMenuDropdown = document.getElementById('user-menu-dropdown');
        // Get both source elements and the video element
        const videoSourceMp4 = document.getElementById('video-source-mp4');
        const videoSourceMov = document.getElementById('video-source-mov');
        const visiMisiVideo = document.getElementById('visi-misi-video');

        let selectedCandidateId = null;

    // Server-provided values
    const npm = String(@json($npm ?? ''));
    let sudahVote = Boolean(@json($sudah_vote ?? 0));

        // --- Dummy Candidate Data for Modals ---
        const candidates = {
            1: {
                name: "Leona Kristin Marbun",
                visi: "Menciptakan Himpunan Mahasiswa Hubungan Masyarakat sebagai ruang tumbuh kolaboratif dan kreatif serta membangun lingkungan organisasi yang nyaman dan berdampak.",
                video_path: "{{ asset('assets/img/candidate 1 video.mp4') }}",
                misi: [
                    "Menguatkan sinergi dan kolaborasi antar departemen agar lebih berkesinambungan dan saling mendukung",
                    "Mendorong kreativitas dalam setiap program kerja agar himpunan menjadi ruang berkembang yang menyenangkan",
                    "Menciptakan lingkungan kerja yang terbuka dan saling menghargai",
                    "Menumbuhkan sikap kritis dalam setiap perencanaan",
                ],
                budayaKerja: [
                    "Respect", "Creative", "Collaborative"
                ]
            },
            2: {
                name: "Muhammad Faishal Akmal",
                visi: "Terwujudnya Hima Humas sebagai ruang untuk pengembangan diri berlandaskan SIKAP (Sinergi, Integritas, Kekeluargaan, Apresiatif, Profesional)",
                video_path: "{{ asset('assets/img/candidate 2 video.mov') }}",
                misi: [
                    "Terwujudnya rasa saling memiliki antar anggota",
                    "Terciptanya komunikasi yang terbuka dan transparan",
                    "Memperkuat dasar organisasi melalui pembekalan, evaluasi dan pendampingan",
                    "Memperkuat sinergi dan kolaborasi antar anggota untuk mencapai tujuan bersama",
                    "Mendorong anggota untuk belajar dan berkembang sesuai dengan minatnya",
                ],
                budayaKerja: [
                    "Respect", "Appreciation", "Reliable",
                ]
            }
        };

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

        // --- Visi Misi Modal Functions ---
        function openVisiMisiModal(candidateId) {
            const candidate = candidates[candidateId];
            if (!candidate) return;

            // Stop any currently playing video before setting new source
            if (visiMisiVideo) {
                visiMisiVideo.pause();
            }

            visiMisiTitle.innerText = `${candidate.name}`;

            // --- DYNAMIC VIDEO UPDATE ---
            if (videoSourceMp4) {
                videoSourceMp4.src = candidate.video_path;
            }
            if (videoSourceMov) {
                videoSourceMov.src = candidate.mov_video_path;
            }

            // Important: Load the new source(s) into the video element
            if (visiMisiVideo) {
                visiMisiVideo.load();
            }
            // ---------------------------

            // Build the Visi Misi content
            let contentHTML = `
                <h4 class="text-xl font-bold text-red-900 mb-2">Visi:</h4>
                <p class="mb-4">${candidate.visi}</p>

                <h4 class="text-xl font-bold text-red-900 mb-2">Misi:</h4>
                <ol class="list-decimal list-inside pl-4 mb-4 space-y-1">
                    ${candidate.misi.map((m, i) => `<li>${m}</li>`).join('')}
                </ol>

                <h4 class="text-xl font-bold text-red-900 mb-2">Budaya Kerja:</h4>
                <ul class="list-disc list-inside pl-4 space-y-1">
                    ${candidate.budayaKerja.map(b => `<li>${b}</li>`).join('')}
                </ul>
            `;
            visiMisiContent.innerHTML = contentHTML;

            visiMisiModal.classList.remove('hidden');
            visiMisiModal.classList.add('flex');
        }

        function closeVisiMisiModal(event) {
            if (event && event.target !== visiMisiModal) return; // Only close if clicking the backdrop

            // Pause video when closing modal
            if (visiMisiVideo) {
                visiMisiVideo.pause();
                visiMisiVideo.currentTime = 0; // Optional: reset to beginning
            }

            visiMisiModal.classList.add('hidden');
            visiMisiModal.classList.remove('flex');
        }

        // --- Vote Confirmation Modal Functions ---
        function openConfirmationModal() {
            // Reset selection state
            selectedCandidateId = null;
            selectionError.classList.add('hidden');
            finalVoteBtn.disabled = true;

            document.querySelectorAll('#confirmation-modal .cursor-pointer').forEach(card => {
                card.classList.remove('selected', 'border-yellow-500');
                card.classList.add('border-gray-200');
            });


            confirmationModal.classList.remove('hidden');
            confirmationModal.classList.add('flex');
        }

        function closeConfirmationModal(event) {
            if (event && event.target !== confirmationModal) return;
            confirmationModal.classList.add('hidden');
            confirmationModal.classList.remove('flex');
        }

        function selectCandidate(id, element) {
            selectedCandidateId = id;
            selectionError.classList.add('hidden');
            finalVoteBtn.disabled = false;

            // Clear visual selection from all cards
            document.querySelectorAll('#confirmation-modal .cursor-pointer').forEach(card => {
                card.classList.remove('selected', 'border-yellow-500');
                card.classList.add('border-gray-200');
            });

            // Apply visual selection to the clicked card
            element.classList.add('selected', 'border-yellow-500');
            element.classList.remove('border-gray-200');
        }

        async function processVote() {
            if (!selectedCandidateId) {
                selectionError.classList.remove('hidden');
                return;
            }

            // Block if already voted
            if (sudahVote) {
                selectionError.classList.remove('hidden');
                selectionError.innerText = 'Anda sudah melakukan vote. Tidak dapat memilih lagi.';
                return;
            }

            // Simulate voting process
            finalVoteBtn.disabled = true;
            finalVoteBtn.innerHTML = `<i class="fas fa-spinner fa-spin mr-2"></i> Memproses...`;
            // Simulate API delay
            try{
                const response = await fetch('/submit-vote', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        npm: npm,
                        candidate_id: selectedCandidateId
                    })
                });
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
            } catch (error) {
                console.error('Error submitting vote:', error);
                finalVoteBtn.disabled = false;
                finalVoteBtn.innerHTML = 'Vote';
                return;
            }

            // Close confirmation and show success
            closeConfirmationModal();
            showSuccessModal();

            // Reset UI state after success
            document.getElementById('vote-sekarang-btn').disabled = true;
            document.getElementById(`candidate-${selectedCandidateId}`).classList.add('selected');

            // Mark as voted to prevent further submissions
            sudahVote = true;
            // disable final vote button
            finalVoteBtn.disabled = true;

            // Reset button text
            finalVoteBtn.innerHTML = 'Vote';
        }

        // --- Success Modal Functions ---
        function showSuccessModal() {
            successModal.classList.remove('hidden');
            successModal.classList.add('flex');
        }

        function closeSuccessModal() {
            successModal.classList.add('hidden');
            successModal.classList.remove('flex');
            // After successful vote, you might redirect the user or lock the voting card
        }

        // Disable main vote button on page load (unless criteria met)
        document.addEventListener('DOMContentLoaded', () => {
                 const mainVoteBtn = document.getElementById('vote-sekarang-btn');
                 mainVoteBtn.disabled = true;
                 mainVoteBtn.innerText = 'Pilih Kandidat untuk Vote';

                 // If already voted, keep voting disabled and show message
                 if (sudahVote) {
                     mainVoteBtn.disabled = true;
                     mainVoteBtn.innerText = 'Anda sudah memilih';
                     mainVoteBtn.classList.add('opacity-50', 'cursor-not-allowed');
                     // Optionally visually disable candidate cards
                     document.querySelectorAll('.candidate-card').forEach(c => c.classList.add('opacity-60', 'pointer-events-none'));
                     return;
                 }

                 // In a real app, this button would be enabled after verifying OTP/Login,
                 // but disabled again after a successful vote.
                 setTimeout(() => {
                     mainVoteBtn.disabled = false;
                     mainVoteBtn.innerText = 'Vote Sekarang!';
                 }, 1000); // Simulated loading time
        });

    </script>

</body>
</html>
