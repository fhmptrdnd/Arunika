@extends('layouts.admin')

@section('content')
    <div class="animate-slide-up">

        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-10 gap-4">
            <div>
                <h1 class="text-[40px] font-bold text-darkblue tracking-wide leading-tight">
                    Data <span class="text-[#12A0D7]">Siswa</span>
                </h1>
                <p class="text-gray-500 text-lg">Kelola seluruh data siswa <br> yang terdaftar di sekolahmu.</p>
            </div>

            <div class="flex items-center gap-3 shrink-0">

                <form action="{{ route('admin.siswa') }}" method="GET" class="relative">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama/kelas..."
                        class="pl-12 pr-3 py-3 rounded-full border-2 border-gray-200 focus:border-[#12A0D7] outline-none w-full md:w-130 transition-all text-sm font-semibold text-gray-600 bg-white">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-lg text-gray-400">🔍</span>
                </form>
                {{-- <button class="bg-[#EAF7FC] text-[#12A0D7] px-6 py-3 rounded-full font-bold hover:bg-[#D6F0FA] transition-colors flex items-center gap-2 border border-blue-100">
                <span class="text-xl leading-none">📁</span> Unggah CSV
            </button> --}}
                {{-- <button onclick="document.getElementById('modalSiswa').classList.remove('hidden')" class="bg-[#12A0D7] text-white px-6 py-3 rounded-full font-bold hover:bg-blue-600 transition-colors shadow-md flex items-center gap-2">
                <span class="text-xl leading-none">+</span> <span class="hidden md:inline">Tambah Siswa</span>
            </button> --}}

            </div>
        </div>

        <div class="bg-white rounded-[30px] border border-gray-100 shadow-[0_2px_15px_rgba(0,0,0,0.02)] overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-[#F8FAFC] border-b border-gray-100 text-gray-400 text-sm tracking-wider uppercase">
                            <th class="p-6 font-bold rounded-tl-[30px]">Profil Siswa</th>
                            <th class="p-6 font-bold">Username</th>
                            <th class="p-6 font-bold">Kelas</th>
                            <th class="p-6 font-bold">Pencapaian</th>
                            <th class="p-6 font-bold text-center rounded-tr-[30px]">Edit</th>
                            <th class="p-6 font-bold text-center rounded-tr-[30px]">Hapus</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($siswa as $s)
                            <tr class="hover:bg-blue-50/50 transition-colors group">
                                <td class="p-6">
                                    <div class="flex items-center gap-4">
                                        <div
                                            class="w-12 h-12 bg-[#FEF5D3] rounded-2xl flex items-center justify-center font-bold text-orange border-2 border-white shadow-sm shrink-0">
                                            {{ strtoupper(substr($s->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <p class="font-bold text-darkblue">{{ $s->name }}</p>
                                            <p class="text-xs text-gray-400 mt-0.5">Terdaftar:
                                                {{ $s->created_at->format('d M Y') }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="p-6 font-semibold text-gray-600">{{ $s->username }}</td>
                                <td class="p-6">
                                    @if ($s->kelas)
                                        <span
                                            class="bg-[#EAF7FC] text-[#12A0D7] px-3 py-1.5 rounded-xl text-sm font-bold border border-blue-50">{{ $s->kelas }}</span>
                                    @else
                                        <span class="text-gray-400 text-sm font-semibold italic">Belum masuk kelas</span>
                                    @endif
                                </td>
                                <td class="p-6">
                                    <div class="flex items-center gap-2">
                                        <span class="text-orange font-bold text-sm bg-[#FFF4E5] px-2 py-1 rounded-lg">⚡
                                            {{ $s->xp ?? 0 }} XP</span>
                                    </div>
                                </td>
                                <td class="p-6 text-center">
                                    <button
                                        onclick="openEditModal(
    '{{ $s->id }}',
    '{{ $s->name }}',
    '{{ $s->username }}',
    '{{ $s->kelas }}'
)"
                                        class="text-gray-400 hover:text-[#12A0D7] font-bold px-3 py-1">
                                        Edit
                                    </button>
                                </td>
                                <td class="p-6 text-center">
                                    <form action="{{ route('admin.siswa.hapus', $s->id) }}" method="POST"
                                        onsubmit="return confirm('Yakin hapus?')">
                                        @csrf
                                        @method('DELETE')

                                        <button class="bg-red-500 text-white px-3 py-1 rounded">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-12 text-center text-gray-400 bg-gray-50/50">
                                    <span class="text-4xl block mb-3">📭</span>
                                    Data siswa tidak ditemukan...
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @if (session('success'))
        <div class="fixed top-10 right-10 bg-green-100 border border-green-200 text-green-700 px-6 py-4 rounded-xl shadow-lg z-200 flex items-center gap-3 font-bold animate-slide-up"
            onclick="this.remove()">
            <span>✅</span> {{ session('success') }}
        </div>
    @endif
    @if ($errors->any())
        <div class="fixed top-10 right-10 bg-red-100 border border-red-200 text-red-700 px-6 py-4 rounded-xl shadow-lg z-200 flex flex-col gap-1 animate-slide-up"
            onclick="this.remove()">
            @foreach ($errors->all() as $error)
                <div class="flex items-center gap-2 font-bold"><span>⚠️</span> {{ $error }}</div>
            @endforeach
        </div>
    @endif

    <div id="modalEdit" class="fixed inset-0 z-50 flex items-center justify-center hidden">

        <!-- BACKDROP -->
        <div class="absolute inset-0 bg-black/50 backdrop-blur-sm transition-opacity" onclick="closeEditModal()"></div>

        <!-- MODAL -->
        <div id="modalContent"
            class="relative bg-white/90 backdrop-blur-xl rounded-[28px] w-full max-w-md p-8 shadow-2xl transform scale-95 opacity-0 transition-all duration-300">

            <!-- CLOSE BUTTON -->
            <button onclick="closeEditModal()"
                class="absolute top-4 right-4 text-gray-400 hover:text-red-400 text-xl transition">
                ✕
            </button>

            <!-- TITLE -->
            <h2 class="text-2xl font-bold text-darkblue mb-6 tracking-wide">
                ✏️ Edit Siswa
            </h2>

            <!-- FORM -->
            <form id="editForm" method="POST" class="flex flex-col gap-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="text-sm font-semibold text-gray-500 ml-1">Nama</label>
                    <input type="text" id="edit_name" name="name"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-[#12A0D7] focus:ring-2 focus:ring-[#12A0D7]/20 outline-none transition">
                </div>

                <div>
                    <label class="text-sm font-semibold text-gray-500 ml-1">Username</label>
                    <input type="text" id="edit_username" name="username"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-[#12A0D7] focus:ring-2 focus:ring-[#12A0D7]/20 outline-none transition">
                </div>

                <div>
                    <label class="text-sm font-semibold text-gray-500 ml-1">Kelas</label>
                    <input type="text" id="edit_kelas" name="kelas"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-[#12A0D7] focus:ring-2 focus:ring-[#12A0D7]/20 outline-none transition">
                </div>

                <button
                    class="mt-2 bg-gradient-to-r from-[#12A0D7] to-blue-500 hover:scale-[1.02] active:scale-[0.98] text-white font-bold py-3 rounded-xl shadow-md transition-all duration-200">
                    Update Data
                </button>
            </form>
        </div>
    </div>
    <script>
        function openEditModal(id, name, username, kelas) {
            const modal = document.getElementById('modalEdit');
            const content = document.getElementById('modalContent');

            modal.classList.remove('hidden');

            // isi data
            document.getElementById('edit_name').value = name;
            document.getElementById('edit_username').value = username;
            document.getElementById('edit_kelas').value = kelas;
            document.getElementById('editForm').action = `/admin/siswa/${id}`;

            // animasi masuk
            setTimeout(() => {
                content.classList.remove('scale-95', 'opacity-0');
                content.classList.add('scale-100', 'opacity-100');
            }, 10);
        }

        function closeEditModal() {
            const modal = document.getElementById('modalEdit');
            const content = document.getElementById('modalContent');

            content.classList.remove('scale-100', 'opacity-100');
            content.classList.add('scale-95', 'opacity-0');

            setTimeout(() => {
                modal.classList.add('hidden');
            }, 200);
        }
    </script>

    <div id="modalSiswa" class="fixed inset-0 z-100 flex items-center justify-center hidden">
        <div class="absolute inset-0 bg-black/40 backdrop-blur-sm cursor-pointer"
            onclick="document.getElementById('modalSiswa').classList.add('hidden')"></div>
        <div class="bg-white rounded-[30px] p-8 w-full max-w-md relative z-10 shadow-2xl">
            <h2 class="text-2xl font-bold text-darkblue mb-6">Daftarkan Siswa Baru</h2>
            <form action="{{ route('admin.siswa.store') }}" method="POST" class="flex flex-col gap-4">
                @csrf
                <div>
                    <label class="block text-gray-500 text-sm font-semibold ml-2 mb-1">Nama Lengkap</label>
                    <input type="text" name="name" required placeholder="Cth: Nadiem Makarim"
                        class="w-full px-5 py-3 rounded-full border-2 border-gray-200 focus:border-[#12A0D7] outline-none">
                </div>
                <div>
                    <label class="block text-gray-500 text-sm font-semibold ml-2 mb-1">Username (Untuk Login)</label>
                    <input type="text" name="username" required placeholder="Cth: nadiem_123"
                        class="w-full px-5 py-3 rounded-full border-2 border-gray-200 focus:border-[#12A0D7] outline-none">
                </div>
                <div>
                    <label class="block text-gray-500 text-sm font-semibold ml-2 mb-1">Password Sementara</label>
                    <input type="text" name="password" required value="arunika123"
                        class="w-full px-5 py-3 rounded-full border-2 border-gray-200 focus:border-[#12A0D7] outline-none">
                    <p class="text-xs text-gray-400 ml-2 mt-1">Default: arunika123 (bisa diubah manual)</p>
                </div>
                <button type="submit"
                    class="w-full bg-[#12A0D7] text-white font-bold py-3 rounded-full mt-2 hover:bg-blue-600 transition-all">Daftarkan
                    Siswa</button>
            </form>
        </div>
    </div>
@endsection
