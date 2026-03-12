@extends('layouts.app')

@section('content')

    @if(session('error_popup') || $errors->any())

        @php
            $pesanError = session('error_popup') ?? $errors->first();
        @endphp

        <div id="error-popup" class="fixed top-20 left-1/2 transform -translate-x-1/2 w-max text-white px-8 py-4
        rounded-full shadow-2xl z-100 flex items-center gap-4 animate-slide-up border-4 bg-red-300 border-red-400">
            <span class="text-3xl">🚨</span>
            <p class="font-bold text-lg m-0">{{ $pesanError }}</p>

            <button type="button" onclick="document.getElementById('error-popup').style.display='none'"
            class="ml-4 font-bold text-xl hover:text-gray-200 cursor-pointer bg-transparent border-none outline-none text-white">
                ✕
            </button>
        </div>

        <script>
            setTimeout(() => {
                const popup = document.getElementById('error-popup');
                if(popup) {
                    popup.style.opacity = '0';
                    popup.style.transform = 'translate(-50%, -20px)';
                    popup.style.transition = 'all 0.5s ease';
                    setTimeout(() => popup.remove(), 500);
                }
            }, 4000);
        </script>
    @endif

<div class="max-w-5xl mx-auto flex flex-col md:flex-row items-center justify-between min-h-[70vh] gap-10 relative z-20">

    <div class="w-full md:w-1/2 text-left animate-slide-up opacity-0 text-darkblue dark:text-white">
        <h1 class="text-5xl font-bold text-darkblue dark:text-white mb-4">
            Masuk ke <span class="text-blue dark:text-yellow">Arunika</span>
        </h1>
        <p class="text-xl text-gray-700 leading-relaxed max-w-md dark:text-white">
            Eksplorasi minat bakat anak dengan pembelajaran interaktif dan menyenangkan
        </p>
    </div>

    <div class="w-full mt-10 md:w-1/2 bg-white rounded-[40px] p-10 shadow-2xl animate-pop-in opacity-0 delay-200">
        <form action="#" method="POST" class="flex flex-col gap-5">
            @csrf

            <div>
                <label class="block text-gray-600 mb-2 font-semibold">Email Anda</label>
                <input type="email" name="email" placeholder="janedoe@gmail.com"
                       class="w-full px-6 py-4 rounded-2xl border-2 border-gray-200 focus:border-blue outline-none transition-colors text-lg">
            </div>

            <div>
                <label class="block text-gray-600 mb-2 font-semibold">Password</label>
                <input type="password" name="password" placeholder="••••••••••"
                       class="w-full px-6 py-4 rounded-2xl border-2 border-gray-200 focus:border-blue outline-none transition-colors text-lg">
            </div>

            {{-- <div>
                <label class="block text-gray-600 mb-2 font-semibold">Kode Sekolah (Jika ada)</label>
                <input type="text" name="school_code" placeholder="######"
                       class="w-full px-6 py-4 rounded-2xl border-2 border-gray-200 focus:border-blue outline-none transition-colors text-lg">
            </div> --}}

            <button type="submit" class="w-full bg-yellow text-darkblue font-bold text-xl py-4 rounded-2xl mt-2 shadow-[0_6px_0_#d9b824] hover:-translate-y-1 hover:shadow-[0_8px_0_#d9b824] active:translate-y-1 active:shadow-[0_2px_0_#d9b824] transition-all">
                Masuk
            </button>

            <a href="#" class="text-darkblue hover:underline text-sm font-semibold mt-2">Lupa Password</a>
        </form>

        <div class="mt-8 pt-6 border-t border-gray-100 text-center text-gray-600">
            Belum punya akun? <a href="{{ route('register') }}" class="text-teal font-bold hover:underline">Daftar sekarang!</a>
        </div>
    </div>
</div>
@endsection
