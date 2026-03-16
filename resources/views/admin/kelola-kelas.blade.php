@extends('layouts.admin')

@section('content')
<div class="animate-slide-up">

    <div class="flex items-center gap-4 mb-8">
        <a href="{{ route('admin.kelas') }}" class="w-12 h-12 bg-white rounded-full flex items-center justify-center border border-gray-200 text-gray-400 hover:text-[#12A0D7] hover:border-[#12A0D7] transition-colors shadow-sm no-underline text-2xl pb-1">
            &larr;
        </a>
        <div>
            <h1 class="text-3xl font-bold text-darkblue">Kelola Kelas <span class="text-[#12A0D7]">{{ $kelas->name }}</span></h1>
            <p class="text-sm text-gray-500 mt-1">
                Wali Kelas: <span class="font-bold text-gray-700">{{ $kelas->homeroomTeacher->name ?? 'Belum ada' }}</span>
            </p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

        <div class="bg-white rounded-[30px] border border-gray-100 shadow-[0_2px_10px_rgba(0,0,0,0.02)] p-8">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-bold text-darkblue flex items-center gap-2">
                    <span>🧑‍🎓</span> Siswa Terdaftar ({{ $siswaDiKelas->count() }})
                </h2>
                <button onclick="document.getElementById('modalSiswa').classList.remove('hidden')"
                class="text-[#12A0D7] bg-[#EAF7FC] hover:bg-[#D6F0FA] p-2 rounded-xl transition-colors font-bold text-sm px-4">
                + Siswa</button>
            </div>

            <div class="flex flex-col gap-3">
                @forelse($siswaDiKelas as $siswa)
                    <div class="flex items-center justify-between p-3 border border-gray-100 rounded-2xl hover:bg-gray-50 transition-colors">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-blue-50 text-blue-500 rounded-full flex items-center justify-center font-bold text-sm">
                                {{ strtoupper(substr($siswa->name, 0, 1)) }}
                            </div>
                            <div>
                                <p class="font-bold text-darkblue text-sm">{{ $siswa->name }}</p>
                                <p class="text-xs text-gray-400">{{ $siswa->username }}</p>
                            </div>
                        </div>
                        <form action="{{ route('admin.kelas.hapus-siswa', $kelas->id) }}" method="POST" onsubmit="return confirm('Keluarkan siswa ini dari kelas?');">
                            @csrf
                            <input type="hidden" name="student_id" value="{{ $siswa->id }}">
                            <button type="submit" class="text-red-400 hover:text-red-600 p-2 text-xl cursor-pointer border-none bg-transparent" title="Keluarkan dari kelas">&times;</button>
                        </form>
                    </div>
                @empty
                    <div class="text-center py-8 text-gray-400 bg-gray-50 rounded-2xl border border-dashed border-gray-200">
                        Belum ada siswa di kelas ini.
                    </div>
                @endforelse
            </div>
        </div>

        <div class="bg-white rounded-[30px] border border-gray-100 shadow-[0_2px_10px_rgba(0,0,0,0.02)] p-8">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-bold text-darkblue flex items-center gap-2">
                    <span>👩‍🏫</span> Guru Mata Pelajaran
                </h2>
                <button onclick="document.getElementById('modalGuru').classList.remove('hidden')"
                class="text-orange bg-[#FFF4E5] hover:bg-[#FDECA6] p-2 rounded-xl transition-colors font-bold text-sm px-4">
                + Guru</button>
            </div>

            <div class="flex flex-col gap-3">
                @forelse($kelas->subjectTeachers as $guruMapel)
                    @php
                        $mapel = \App\Models\Subject::find($guruMapel->pivot->subject_id);
                    @endphp

                    <div class="flex items-center justify-between p-3 border border-gray-100 rounded-2xl hover:bg-gray-50 transition-colors">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 {{ $mapel->color ?? 'bg-gray-100' }} rounded-xl flex items-center justify-center text-lg">
                                {{ $mapel->icon ?? '📘' }}
                            </div>
                            <div>
                                <p class="font-bold text-darkblue text-sm">{{ $mapel->name ?? 'Mapel' }}</p>
                                <p class="text-xs text-gray-500">Pengajar: <span class="font-semibold">{{ $guruMapel->name }}</span></p>
                            </div>
                        </div>
                        <form action="{{ route('admin.kelas.hapus-guru-mapel', $kelas->id) }}" method="POST" onsubmit="return confirm('Hapus tugas guru mapel ini?');">
                            @csrf
                            <input type="hidden" name="teacher_id" value="{{ $guruMapel->id }}">
                            <input type="hidden" name="subject_id" value="{{ $mapel->id }}">
                            <button type="submit" class="text-red-400 hover:text-red-600 p-2 text-xl cursor-pointer border-none bg-transparent" title="Hapus guru mapel">&times;</button>
                        </form>
                    </div>
                @empty
                    <div class="text-center py-8 text-gray-400 bg-gray-50 rounded-2xl border border-dashed border-gray-200">
                        Belum ada guru mapel yang ditugaskan.
                    </div>
                @endforelse
            </div>
        </div>

    </div>
</div>

<div id="modalSiswa" class="fixed inset-0 z-100 flex items-center justify-center hidden">
    <div class="absolute inset-0 bg-black/40 backdrop-blur-sm cursor-pointer" onclick="document.getElementById('modalSiswa').classList.add('hidden')"></div>
    <div class="bg-white rounded-[30px] p-8 w-full max-w-md relative z-10 shadow-2xl">
        <h2 class="text-2xl font-bold text-darkblue mb-6">Pilih Siswa</h2>
        <form action="{{ route('admin.kelas.tambah-siswa', $kelas->id) }}" method="POST" class="flex flex-col gap-5">
            @csrf
            <select name="student_id" required class="w-full px-5 py-3 rounded-full border-2 border-gray-200 focus:border-[#12A0D7] outline-none transition-colors">
                <option value="" disabled selected>-- Pilih Siswa yang Tersedia --</option>
                @foreach($siswaTersedia as $s)
                    <option value="{{ $s->id }}">{{ $s->name }} ({{ $s->username }})</option>
                @endforeach
            </select>
            <button type="submit" class="w-full bg-[#12A0D7] text-white font-bold py-3 rounded-full hover:bg-blue-600 transition-all">Tambahkan Siswa</button>
        </form>
    </div>
</div>

<div id="modalGuru" class="fixed inset-0 z-100 flex items-center justify-center hidden">
    <div class="absolute inset-0 bg-black/40 backdrop-blur-sm cursor-pointer" onclick="document.getElementById('modalGuru').classList.add('hidden')"></div>
    <div class="bg-white rounded-[30px] p-8 w-full max-w-md relative z-10 shadow-2xl">
        <h2 class="text-2xl font-bold text-darkblue mb-6">Tugaskan Guru Mapel</h2>
        <form action="{{ route('admin.kelas.tambah-guru-mapel', $kelas->id) }}" method="POST" class="flex flex-col gap-4">
            @csrf
            <select name="teacher_id" required class="w-full px-5 py-3 rounded-full border-2 border-gray-200 focus:border-[#12A0D7] outline-none">
                <option value="" disabled selected>-- Pilih Guru --</option>
                @foreach($semuaGuru as $g)
                    <option value="{{ $g->id }}">{{ $g->name }}</option>
                @endforeach
            </select>
            <select name="subject_id" required class="w-full px-5 py-3 rounded-full border-2 border-gray-200 focus:border-[#12A0D7] outline-none">
                <option value="" disabled selected>-- Pilih Mata Pelajaran --</option>
                @foreach($semuaMapel as $m)
                    <option value="{{ $m->id }}">{{ $m->name }} {{ $m->icon }}</option>
                @endforeach
            </select>
            <button type="submit" class="w-full bg-orange text-white font-bold py-3 rounded-full mt-2 hover:bg-orange-600 transition-all">Tugaskan Guru</button>
        </form>
    </div>
</div>
@endsection
