<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Pemilu Raya Hima Humas 2025') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <style>
            /* Tailwind CSS styles */
        </style>
    @endif
</head>
<body class="overflow-x-hidden bg-gradient-to-r from-[#780002] to-[#3b0a0a]">
    <section id="hero" class="relative flex flex-col px-5 py-10 lg:px-12 lg:py-20">
        <div class="flex flex-row justify-between z-20">
            <div>
                <h3 class=" text-white font-inter lg:text-xl">Kabinet</h3>
                <h3 class=" text-white font-inter lg:text-xl font-bold">Andikara</h3>
            </div>
            <img src="{{asset('assets/img/logo 2.png')}}" class=" w-16 relative bottom-4 lg:w-20" alt="">
        </div>
        <div class="z-20 px-10 py-10 flex flex-col items-center justify-center md:flex-row">
            <div class="lg:px-10">
                <div class="bg-[#FFDB4F] text-center rounded-lg shadow-lg p-6">
                    <p class="text-lg font-bold md:text-2xl lg:text-4xl">Waduh! Halaman yang Anda Cari Tidak Ditemukan</p>
                </div>
                <div class="my-5 flex flex-col items-center">
                    <p class="text-white text-sm lg:text-xl">Mending balik ke beranda aja yuk</p>
                    <a href="/" class="mt-4">
                        <button class="bg-[#FFDB4F] italic px-5 py-2 rounded-full font-bold hover:bg-amber-400 transition duration-300">
                            Kembali ke Beranda
                        </button>
                    </a>
                </div>
            </div>
        </div>
        <div class="absolute -left-10 bottom-0 md:-bottom-28 lg:-bottom-48 lg:w-3/4">
            <img src="{{ asset('assets/img/background effect.png') }}" alt="Background Effect" class="opacity-30">
        </div>
    </section>
</body>
</html>
