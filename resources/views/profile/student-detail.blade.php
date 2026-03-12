@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto flex flex-col items-center justify-center min-h-[75vh] relative z-20">

    <a href="{{ route('profile.students') }}"
        class="bg-yellow my-10 text-darkblue font-bold px-6 py-2 rounded-full shadow-[0_4px_0_#d9b824] hover:-translate-y-1 hover:shadow-[0_6px_0_#d9b824] active:translate-y-1 active:shadow-[0_0px_0_#d9b824] transition-all no-underline gap-3">
            Kembali ke Daftar Murid
    </a>

    <div class="bg-white rounded-[40px] shadow-2xl mb-10 w-full p-10 flex flex-col items-center">

        <div class="w-32 h-32 bg-white rounded-full flex items-center justify-center font-bold text-5xl text-[#12A0D7] shadow-sm border-4 border-blue-100 mb-4">
            {{ substr($student->child_name, 0, 1) }}
        </div>

        <h1 class="text-3xl font-bold text-darkblue">{{ $student->child_name }}</h1>
        <p class="text-lg text-gray-500 mb-8">{{ $student->class_age }}</p>

        <div class="w-full bg-gray-50 rounded-2xl p-6 mb-8 grid grid-cols-1 md:grid-cols-2 gap-4 text-left">
            <div>
                <p class="text-sm text-gray-400 font-semibold">Nama Wali Murid</p>
                <p class="text-lg font-bold text-gray-700">{{ $student->name }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-400 font-semibold">Email Wali</p>
                <p class="text-lg font-bold text-gray-700">{{ $student->email }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-400 font-semibold">Bergabung Sejak</p>
                <p class="text-lg font-bold text-gray-700">{{ $student->created_at->format('d M Y') }}</p>
            </div>
        </div>

        <form action="{{ route('profile.student.kick', $student->id) }}" method="POST" class="w-full" onsubmit="return confirm('Yakin ingin mengeluarkan {{ $student->child_name }} dari kelas ini?');">
            @csrf
            <button type="submit" class="w-full bg-red-100 text-red-600 font-bold px-6 py-4 rounded-full border-2 border-red-200 hover:bg-red-600 hover:text-white transition-colors cursor-pointer text-lg">
                Keluarkan Murid dari Kelas
            </button>
        </form>

    </div>
</div>
@endsection
