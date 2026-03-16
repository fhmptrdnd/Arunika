@extends('layouts.admin')

@section('content')
<div class="animate-slide-up">

    <h1 class="text-[40px] font-bold text-darkblue mb-10 tracking-wide">
        Manajemen <span class="text-[#12A0D7]">Kelas</span>
    </h1>

    @if(session('success'))
        <div class="bg-green-100 border border-green-200 text-green-700 px-6 py-4 rounded-xl mb-6 flex justify-between items-center animate-slide-up">
            <div class="flex items-center gap-3 font-bold">
                <span class="text-xl">✅</span>
                {{ session('success') }}
            </div>
            <button onclick="this.parentElement.style.display='none'" class="text-green-600 hover:text-green-800 font-bold text-xl leading-none">&times;</button>
        </div>
    @endif

    @if($errors->any())
        <div class="bg-red-100 border border-red-200 text-red-700 px-6 py-4 rounded-xl mb-6 flex flex-col gap-1 animate-slide-up">
            @foreach($errors->all() as $error)
                <div class="flex items-center gap-3 font-bold">
                    <span class="text-xl">⚠️</span> {{ $error }}
                </div>
            @endforeach
        </div>
    @endif

    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
        <p class="text-gray-500 text-lg">Kelola pembagian kelas, wali kelas, dan guru mata pelajaran di sini.</p>
        <button onclick="openModalTambahKelas()" class="bg-[#12A0D7] text-white px-6 py-3 rounded-full font-bold hover:bg-blue-600 transition-colors shadow-md flex items-center gap-2 shrink-0 cursor-pointer">
            <img src="{{ asset('images/icon-plus.png') }}" class="w-5 h-5"> Tambah Kelas
        </button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

        @php
            $themes = [
                ['bg' => 'bg-[#E6F8F3]', 'text' => 'text-[#05A660]'], // Hijau
                ['bg' => 'bg-[#FFF4E5]', 'text' => 'text-[#F7891F]'], // Oranye
                ['bg' => 'bg-[#EAF7FC]', 'text' => 'text-[#12A0D7]'], // Biru
                ['bg' => 'bg-[#FEF5D3]', 'text' => 'text-[#7A6311]'], // Kuning
            ];

            $avatarColors = [
                ['bg' => 'bg-blue-100', 'text' => 'text-blue-600'],
                ['bg' => 'bg-orange-100', 'text' => 'text-orange-600'],
                ['bg' => 'bg-green-100', 'text' => 'text-green-600'],
                ['bg' => 'bg-pink-100', 'text' => 'text-pink-600'],
            ];
        @endphp

        @forelse($kelas as $index => $k)
            @php
                $theme = $themes[$index % count($themes)];

                $siswaKelas = \App\Models\User::where('role', 'student')
                                ->where('kelas', $k->name)
                                ->where('school_code', auth()->user()->school_code)
                                ->get();

                $jumlahSiswa = $siswaKelas->count();
            @endphp

            <div class="bg-white rounded-3xl border border-gray-100 shadow-[0_2px_10px_rgba(0,0,0,0.02)] p-6 hover:-translate-y-1 transition-transform flex flex-col justify-between h-full">

                <div>
                    <div class="flex justify-between items-start mb-4">
                        <div class="w-14 h-14 {{ $theme['bg'] }} {{ $theme['text'] }} font-bold text-2xl rounded-2xl flex items-center justify-center shadow-sm">
                            {{ $k->name }}
                        </div>
                        <button class="text-gray-400 hover:text-[#12A0D7] transition-colors text-xl font-bold pb-2 cursor-pointer border-none bg-transparent">•••</button>
                    </div>

                    <h3 class="font-bold text-darkblue text-xl mb-1">Kelas {{ $k->name }}</h3>
                    <p class="text-sm text-gray-500 mb-6 flex items-center gap-2">
                        <span class="text-lg">👨‍🏫</span> Wali:
                        <span class="font-semibold text-gray-700 truncate">
                            {{ $k->homeroomTeacher->name ?? 'Belum Ditugaskan' }}
                        </span>
                    </p>
                </div>

                <div class="border-t border-gray-100 pt-4 flex justify-between items-center mt-auto">
                    <div class="flex items-center gap-3">
                        <div class="flex -space-x-3">

                            @if($jumlahSiswa > 0)
                                @foreach($siswaKelas->take(3) as $i => $siswa)
                                    @php
                                        $c = $avatarColors[$i % count($avatarColors)];
                                        $inisial = strtoupper(substr($siswa->name, 0, 1));
                                    @endphp
                                    <div class="w-8 h-8 rounded-full border-2 border-white {{ $c['bg'] }} flex items-center justify-center text-[10px] font-bold {{ $c['text'] }}" title="{{ $siswa->name }}">
                                        {{ $inisial }}
                                    </div>
                                @endforeach

                                @if($jumlahSiswa > 3)
                                    <div class="w-8 h-8 rounded-full border-2 border-white bg-gray-100 flex items-center justify-center text-[10px] font-bold text-gray-500">
                                        +{{ $jumlahSiswa - 3 }}
                                    </div>
                                @endif
                            @else
                                <div class="w-8 h-8 rounded-full border-2 border-white bg-gray-50 flex items-center justify-center text-[10px] font-bold text-gray-400">?</div>
                            @endif

                        </div>
                        <span class="text-xs font-bold text-gray-400">{{ $jumlahSiswa }} Siswa</span>
                    </div>
                    <a href="{{ route('admin.kelas.kelola', $k->id) }}" class="text-sm text-[#12A0D7] font-bold hover:underline no-underline cursor-pointer">Kelola</a>
                </div>
            </div>

        @empty
            <div class="col-span-full bg-white rounded-3xl border border-gray-200 border-dashed p-10 flex flex-col items-center justify-center text-center">
                <span class="text-4xl mb-4">🏫</span>
                <h3 class="font-bold text-darkblue text-xl mb-2">Belum Ada Kelas</h3>
                <p class="text-gray-400">Silakan klik tombol "Tambah Kelas" untuk mulai membuat ruangan kelas.</p>
            </div>
        @endforelse

    </div>
</div>

<div id="modalTambahKelas" class="fixed inset-0 z-100 items-center justify-center hidden">

    <div class="absolute inset-0 bg-black/40 backdrop-blur-sm cursor-pointer" onclick="closeModalTambahKelas()"></div>

    <div class="bg-white rounded-[30px] p-8 w-full max-w-md relative z-10 shadow-2xl transform scale-95 opacity-0 transition-all duration-300" id="modalContent">

        <button onclick="closeModalTambahKelas()" class="absolute top-6 right-6 text-gray-400 hover:text-red-500 text-2xl font-bold cursor-pointer border-none bg-transparent leading-none">&times;</button>

        <h2 class="text-2xl font-bold text-darkblue mb-6">Tambah Kelas Baru</h2>

        <form action="{{ route('admin.kelas.store') }}" method="POST" class="flex flex-col gap-5">
            @csrf

            <div>
                <label class="block text-gray-500 mb-1 text-sm font-semibold ml-2">Nama Kelas</label>
                <input type="text" name="name" placeholder="Contoh: 1A, 5B, Kelas Melati" required
                       class="w-full px-5 py-3 rounded-full border-2 border-gray-200 focus:border-[#12A0D7] outline-none transition-colors">
            </div>

            <div>
                <label class="block text-gray-500 mb-1 text-sm font-semibold ml-2">Wali Kelas (Opsional)</label>
                <select name="homeroom_teacher_id"
                        class="w-full px-5 py-3 rounded-full border-2 border-gray-200 focus:border-[#12A0D7] outline-none transition-colors text-gray-600 bg-white cursor-pointer appearance-none">
                    <option value="" selected>Belum ada Wali Kelas</option>
                    @foreach($semuaGuru as $guru)
                        <option value="{{ $guru->id }}">{{ $guru->name }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="w-full bg-[#12A0D7] text-white font-bold text-lg py-4 rounded-full mt-2 shadow-[0_4px_15px_rgba(18,160,215,0.3)] hover:-translate-y-1 hover:shadow-[0_6px_20px_rgba(18,160,215,0.4)] transition-all cursor-pointer">
                Simpan Kelas
            </button>
        </form>

    </div>
</div>

<script>
    function openModalTambahKelas() {
        const modal = document.getElementById('modalTambahKelas');
        const content = document.getElementById('modalContent');

        modal.classList.remove('hidden');
        modal.classList.add('flex');

        setTimeout(() => {
            content.classList.remove('scale-95', 'opacity-0');
            content.classList.add('scale-100', 'opacity-100');
        }, 10);
    }

    function closeModalTambahKelas() {
        const modal = document.getElementById('modalTambahKelas');
        const content = document.getElementById('modalContent');

        content.classList.remove('scale-100', 'opacity-100');
        content.classList.add('scale-95', 'opacity-0');

        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }
</script>
@endsection
