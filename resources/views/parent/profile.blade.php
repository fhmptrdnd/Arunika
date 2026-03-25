@extends('layouts.parent')

@section('content')
<div class="max-w-5xl animate-slide-up relative">

    <div class="flex justify-between items-center mb-10">
        <h1 class="text-2xl text-gray-600 tracking-wide">
            Halo, <span class="font-bold text-darkblue">{{ auth()->user()->name ?? 'Orang Tua' }}!</span>
        </h1>
        <div class="flex gap-4">
            <div class="bg-[#FEF5D3] text-orange font-bold px-6 py-2.5 rounded-full text-sm shadow-sm flex items-center gap-2">
                🔥 7 Hari
            </div>
            <div class="bg-[#12A0D7] text-white font-bold px-6 py-2.5 rounded-full text-sm shadow-sm flex items-center gap-2">
                ⚡ 450 xp
            </div>
        </div>
    </div>

    <div class="bg-white rounded-[40px] border border-gray-100 shadow-[0_2px_15px_rgba(0,0,0,0.03)] p-10 flex flex-col lg:flex-row gap-12 mb-10">

        <div class="flex flex-col items-center justify-center lg:border-r border-gray-100 lg:pr-12 shrink-0">
            <div class="w-50 h-50 flex items-center justify-center mb-6">
                <img src="{{ asset('images/OrangTua.png') }}" alt="Orang Tua">
            </div>
            <span class="bg-[#FEF5D3] text-orange font-bold tracking-widest text-xs px-5 py-2 rounded-full mb-3 uppercase">
                Orang Tua
            </span>
            <h2 class="text-3xl font-bold text-darkblue mb-1">{{ auth()->user()->name }}</h2>
            <p class="text-gray-400 font-semibold">{{ auth()->user()->email }}</p>
        </div>

        <div class="flex-1 w-full">
            <h3 class="text-xl font-bold text-gray-400 mb-4 border-b border-gray-100 pb-4">Informasi Akun</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-[#F8FAFC] p-6 rounded-3xl">
                    <p class="text-sm text-gray-400 font-bold mb-1">Nama Sekolah</p>
                    <p class="text-lg font-bold text-darkblue">{{ auth()->user()->school_name ?? 'Mandiri' }}</p>
                </div>
                <div class="bg-[#F4FBFE] p-6 rounded-3xl flex items-center min-h-[100px]">
                    @if(auth()->user()->school_code)
                        <div class="flex justify-between items-center w-full">
                            <div>
                                <p class="text-sm text-[#12A0D7] font-bold mb-1">Kode Sekolah</p>
                                <p class="text-xl font-bold text-[#12A0D7] tracking-widest uppercase">{{ auth()->user()->school_code }}</p>
                            </div>
                            <button onclick="navigator.clipboard.writeText('{{ auth()->user()->school_code }}'); alert('Kode Sekolah berhasil disalin!');"
                                class="w-10 h-10 bg-white rounded-full flex items-center justify-center shadow-sm text-[#12A0D7] hover:bg-[#12A0D7] hover:text-white transition-all cursor-pointer border-none outline-none">
                                <i class="bi bi-copy text-lg"></i>
                            </button>
                        </div>
                    @else
                        <div class="w-full">
                            <p class="text-sm text-[#12A0D7] font-bold mb-2">Masukkan Kode Sekolah</p>
                            <form action="{{ route('parent.update_school') }}" method="POST" class="flex gap-2 w-full">
                                @csrf
                                <input type="text" name="school_code" placeholder="Cth: ARN001" required
                                    class="w-full bg-white border border-[#12A0D7]/30 text-darkblue font-bold rounded-xl px-4 py-2 focus:outline-none focus:border-[#12A0D7] focus:ring-2 focus:ring-[#12A0D7]/20 transition-all text-sm uppercase">

                                <button type="submit" class="w-10 h-10 bg-[#12A0D7] hover:bg-blue-600 text-white rounded-xl transition-colors shadow-sm flex items-center justify-center shrink-0 cursor-pointer border-none outline-none">
                                    <i class="bi bi-floppy text-lg"></i>
                                </button>
                            </form>
                            @error('school_code')
                                <p class="text-red-500 text-[10px] font-bold mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="flex justify-between items-center mb-6">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center shadow-sm border border-gray-100 text-2xl">👩</div>
            <h2 class="text-2xl font-bold text-darkblue">
                <span class="text-[#12A0D7]">{{ auth()->user()->children->count() }}</span> Anak Terdaftar
            </h2>
        </div>
        <button onclick="openAddChildModal()" class="bg-[#12A0D7] text-white px-6 py-3 rounded-full font-bold hover:bg-blue-600 transition-colors shadow-md flex items-center gap-2 cursor-pointer border-none outline-none">
            <span class="text-xl leading-none">+</span> Tambah Anak
        </button>
    </div>

    <div class="flex flex-col gap-4">
        @forelse(auth()->user()->children as $index => $child)
            <div class="bg-white border-gray-200 rounded-[30px] border-2 p-6 flex items-center gap-6 cursor-pointer hover:-translate-y-1 transition-transform">

                <div class="w-24 h-24 bg-[#FEF5D3] rounded-full border-4 border-white shadow-md flex items-center justify-center mb-4">
                    <span class="text-4xl font-bold text-orange">{{ strtoupper(substr($child->name, 0, 1)) }}</span>
                </div>

                <div class="flex-1">
                    <h3 class="text-2xl font-bold text-darkblue mb-1">{{ $child->name }}</h3>
                    <p class="text-gray-500 font-semibold mb-4">{{ $child->kelas }} · {{ $child->school_name ?? 'Belajar Mandiri' }}</p>

                    <div class="flex flex-wrap gap-3">
                        <span class="bg-white border border-gray-100 text-orange px-4 py-1.5 rounded-full text-sm font-bold flex items-center gap-1 shadow-sm">
                            ⚡ {{ $child->xp ?? 0 }} XP
                        </span>
                        <span class="bg-white border border-gray-100 text-red-500 px-4 py-1.5 rounded-full text-sm font-bold flex items-center gap-1 shadow-sm">
                            🔥 {{ $child->streak ?? 0 }} Hari
                        </span>
                        <span class="bg-white border border-gray-100 text-[#05A660] px-4 py-1.5 rounded-full text-sm font-bold flex items-center gap-1 shadow-sm">
                            Aktif hari ini
                        </span>
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-white border-2 border-dashed border-gray-200 rounded-[30px] p-10 text-center text-gray-400">
                Belum ada anak yang terdaftar. Yuk tambahkan akun anak Anda!
            </div>
        @endforelse
    </div>

</div>

<div id="addChildModal" class="fixed inset-0 z-100 bg-darkblue/40 backdrop-blur-sm hidden flex-col items-center justify-center p-4 opacity-0 transition-opacity duration-300">
    <div id="addChildModalContent" class="bg-white rounded-[3rem] p-8 md:p-10 w-full max-w-lg shadow-2xl transform scale-95 transition-transform duration-300 relative">

        <button onclick="closeAddChildModal()" class="absolute top-6 right-6 w-10 h-10 bg-gray-50 text-gray-400 hover:bg-red-50 hover:text-red-500 rounded-full flex items-center justify-center transition-colors cursor-pointer border-none outline-none">
            <i class="bi bi-x-lg text-xl"></i>
        </button>

        <div class="text-center mb-8">
            <div class="w-20 h-20 bg-[#EAF7FC] rounded-full flex items-center justify-center text-4xl mx-auto mb-4 shadow-inner">
                👦
            </div>
            <h2 class="text-3xl font-bold text-darkblue">Tambah Akun Anak</h2>
            <p class="text-gray-500 mt-2">Buat profil baru agar anak Anda bisa mulai berpetualang.</p>
        </div>

        <form action="{{ route('parent.store_child') }}" method="POST" class="flex flex-col gap-4">
            @csrf

            <div>
                <label class="block text-sm font-bold text-gray-500 mb-2 pl-2">Nama Lengkap Anak</label>
                <input type="text" name="name" required placeholder="Contoh: Budi Santoso"
                    class="w-full bg-gray-50 border border-gray-200 text-darkblue font-semibold rounded-2xl px-5 py-4 focus:outline-none focus:border-[#12A0D7] focus:ring-2 focus:ring-[#12A0D7]/20 transition-all">
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-500 mb-2 pl-2">Username Anak (Untuk Login)</label>
                <input type="text" name="username" required placeholder="Contoh: budi123"
                    class="w-full bg-gray-50 border border-gray-200 text-darkblue font-semibold rounded-2xl px-5 py-4 focus:outline-none focus:border-[#12A0D7] focus:ring-2 focus:ring-[#12A0D7]/20 transition-all">

                @error('username')
                    <p class="text-red-500 text-xs font-bold mt-2 pl-2">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-2">
                <div>
                    <label class="block text-sm font-bold text-gray-500 mb-2 pl-2">Kelas</label>
                    <select name="kelas" required class="w-full bg-gray-50 border border-gray-200 text-darkblue font-semibold rounded-2xl px-5 py-4 focus:outline-none focus:border-[#12A0D7] focus:ring-2 focus:ring-[#12A0D7]/20 transition-all appearance-none">
                        <option value="" disabled selected>Pilih Kelas</option>
                        <option value="Kelas 1">Kelas 1</option>
                        <option value="Kelas 2">Kelas 2</option>
                        <option value="Kelas 3">Kelas 3</option>
                    </select>
                </div>

                <div class="bg-[#EAF7FC] border border-[#12A0D7]/20 rounded-2xl p-4 flex flex-col justify-center">
                    <p class="text-[11px] font-bold text-[#12A0D7] uppercase tracking-wider mb-0.5"><i class="bi bi-shield-lock-fill"></i> Info Keamanan</p>
                    <p class="text-xs text-gray-600 font-semibold leading-tight">Password anak akan dibuat <span class="text-darkblue font-bold">sama persis</span> dengan password Anda.</p>
                </div>
            </div>

            <div class="mt-6">
                <button type="submit" class="w-full bg-[#12A0D7] hover:bg-blue-600 text-white font-bold text-lg py-4 rounded-full shadow-[0_6px_0_#0E82B0] hover:shadow-[0_3px_0_#0E82B0] hover:translate-y-1 transition-all cursor-pointer border-none outline-none">
                    Simpan Akun Anak
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openAddChildModal() {
        const modal = document.getElementById('addChildModal');
        const modalContent = document.getElementById('addChildModalContent');

        modal.classList.remove('hidden');
        modal.classList.add('flex');

        setTimeout(() => {
            modal.classList.remove('opacity-0');
            modalContent.classList.remove('scale-95');
            modalContent.classList.add('scale-100');
        }, 10);
    }

    function closeAddChildModal() {
        const modal = document.getElementById('addChildModal');
        const modalContent = document.getElementById('addChildModalContent');

        modal.classList.add('opacity-0');
        modalContent.classList.remove('scale-100');
        modalContent.classList.add('scale-95');

        setTimeout(() => {
            modal.classList.remove('flex');
            modal.classList.add('hidden');
        }, 300);
    }

    document.getElementById('addChildModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeAddChildModal();
        }
    });
</script>

@endsection
