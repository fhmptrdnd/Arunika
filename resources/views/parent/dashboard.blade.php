@extends('layouts.parent') @section('content')
<div class="mb-10 animate-slide-up">
    <h1 class="text-4xl md:text-5xl font-bold text-darkblue mb-3">Selamat Datang, {{ explode(' ', trim($parent->name))[0] }}!</h1>
    <p class="text-lg text-gray-500">Pantau terus petualangan dan perkembangan belajar anak-anak hebat Anda di Arunika.</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 animate-pop-in delay-100">
    @forelse($children as $child)
    <div class="bg-white rounded-4xl p-8 shadow-sm border border-gray-100 flex flex-col items-center text-center hover:-translate-y-2 transition-transform duration-300">
        <div class="w-24 h-24 bg-[#FEF5D3] rounded-full border-4 border-white shadow-md flex items-center justify-center mb-4">
            <span class="text-4xl font-bold text-orange">{{ strtoupper(substr($child->name, 0, 1)) }}</span>
        </div>
        <h3 class="text-2xl font-bold text-darkblue">{{ $child->name }}</h3>
        <p class="text-gray-400 font-semibold mb-6">{{ $child->kelas ?? 'Belum ada kelas' }} • {{ $child->school_name ?? 'Sekolah Mandiri' }}</p>

        <div class="flex w-full gap-3">
            <a href="{{ route('parent.perkembangan', ['child_id' => $child->id]) }}" class="flex-1 bg-[#12A0D7] hover:bg-blue-500 text-white font-bold px-4 rounded-full transition-colors no-underline text-sm">
                Lihat Rapor
            </a>
            <a href="{{ route('parent.riwayat', ['child_id' => $child->id]) }}" class="flex-1 bg-yellow hover:bg-yellow-400 text-darkblue font-bold py-3 px-4 rounded-full transition-colors no-underline text-sm">
                Aktivitas
            </a>
        </div>
    </div>
    @empty
    <div class="col-span-full bg-white p-10 rounded-3xl text-center border border-dashed border-gray-300">
        <p class="text-gray-500 text-lg">Belum ada data anak yang terhubung dengan akun ini.</p>
    </div>
    @endforelse
</div>
@endsection
