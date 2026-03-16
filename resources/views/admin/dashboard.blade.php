@extends('layouts.admin')

@section('content')
<div class="animate-slide-up">

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">

        <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-[0_2px_10px_rgba(0,0,0,0.02)] flex flex-col justify-center transition-transform hover:-translate-y-1">
            <div class="w-14 h-14 bg-[#EAF7FC] rounded-2xl flex items-center justify-center mb-6">
                <i class="bi bi-people-fill text-[#12A0D7] text-3xl"></i>
            </div>
            <p class="text-[11px] text-gray-400 font-bold uppercase tracking-widest mb-2">Siswa Aktif</p>
            <h3 class="text-[40px] leading-none font-bold text-darkblue">{{ number_format($totalSiswa) }}</h3>
        </div>

        <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-[0_2px_10px_rgba(0,0,0,0.02)] flex flex-col justify-center transition-transform hover:-translate-y-1">
            <div class="w-14 h-14 bg-[#FFF4E5] rounded-2xl flex items-center justify-center mb-6">
                <i class="bi bi-person-badge-fill text-orange text-3xl"></i>
            </div>
            <p class="text-[11px] text-gray-400 font-bold uppercase tracking-widest mb-2">Total Guru</p>
            <h3 class="text-[40px] leading-none font-bold text-darkblue">{{ number_format($totalGuru) }}</h3>
        </div>

        <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-[0_2px_10px_rgba(0,0,0,0.02)] flex flex-col justify-center transition-transform hover:-translate-y-1">
            <div class="w-14 h-14 bg-[#E6F8F3] rounded-2xl flex items-center justify-center mb-6">
                <i class="bi bi-door-open-fill text-[#05A660] text-3xl"></i>
            </div>
            <p class="text-[11px] text-gray-400 font-bold uppercase tracking-widest mb-2">Ruang Kelas</p>
            <h3 class="text-[40px] leading-none font-bold text-darkblue">{{ number_format($totalKelas) }}</h3>
        </div>

    </div>

    <h2 class="text-2xl font-bold text-darkblue mb-8 tracking-wide">
        Administrasi {{ auth()->user()->school_name ?? 'Sekolah Arunika' }}
    </h2>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-[0_2px_10px_rgba(0,0,0,0.02)]">
            <h3 class="font-bold text-darkblue mb-6 text-xl">User Sedang Online</h3>

            <div class="border-[1.5px] border-[#12A0D7] bg-[#F4FBFE] rounded-3xl py-10 px-6 flex flex-col items-center justify-center h-45">
                <div class="flex items-center justify-center gap-3 mb-2">
                    <span class="relative flex h-4 w-4">
                      <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                      <span class="relative inline-flex rounded-full h-4 w-4 bg-green-500"></span>
                    </span>
                    <p class="font-bold text-gray-500 tracking-wider uppercase text-sm">Status Online</p>
                </div>
                <h3 class="text-5xl font-bold text-darkblue mb-1">{{ $onlineUsers }}</h3>
                <p class="text-sm text-gray-400">User dari sekolahmu sedang online</p>
            </div>
        </div>

        <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-[0_2px_10px_rgba(0,0,0,0.02)] flex flex-col justify-start">
            <h3 class="font-bold text-darkblue mb-6 text-xl">Kode Unik Sekolah</h3>

            <div class="border border-gray-200 rounded-full px-8 py-5 flex items-center justify-between mt-2 shadow-sm relative group">
                <i class="bi bi-buildings text-gray-400 text-xl mr-1"></i>
                <span id="kodeSekolah" class="text-lg font-bold tracking-widest text-darkblue flex-1 ml-1">
                    {{ auth()->user()->school_code ?? 'ARN001' }}
                </span>
                <button onclick="salinKode()" id="btnSalin" class="text-[#12A0D7] font-bold text-[15px] hover:text-blue-700 transition-colors cursor-pointer border-none bg-transparent flex items-center gap-1.5 ml-4">
                    <i class="bi bi-clipboard"></i> Salin
                </button>
            </div>
        </div>

    </div>
</div>

<script>
    function salinKode() {
        const kode = document.getElementById('kodeSekolah').innerText;

        navigator.clipboard.writeText(kode).then(() => {
            const btn = document.getElementById('btnSalin');
            const teksAsli = btn.innerHTML;
            btn.innerHTML = '<i class="bi bi-clipboard-check"></i> Tersalin! ✅';
            btn.classList.replace('text-[#12A0D7]', 'text-green-500');

            setTimeout(() => {
                btn.innerHTML = teksAsli;
                btn.classList.replace('text-green-500', 'text-[#12A0D7]');
            }, 2000);
        }).catch(err => {
            alert('Gagal menyalin kode: ', err);
        });
    }
</script>
@endsection
