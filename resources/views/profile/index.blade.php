@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mt-10 mx-auto flex flex-col items-center justify-center min-h-[75vh] relative z-20">

        <div class="bg-white rounded-[40px] shadow-2xl w-full p-10 flex flex-col md:flex-row gap-10 animate-pop-in opacity-0 delay-200">

            <div class="w-full md:w-1/3 flex flex-col items-center justify-center border-b md:border-b-0 md:border-r border-gray-100 pb-8 md:pb-0">

                <div class="w-32 h-32 bg-blue-100 text-[#12A0D7] rounded-[30px] flex items-center justify-center text-5xl font-bold mb-6 border-4 border-[#EAF7FC] shadow-sm">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>

                <span class="bg-[#EAF7FC] text-[#12A0D7] font-bold px-5 py-2 rounded-full text-sm tracking-widest uppercase mb-3">
                    Pelajar
                </span>

                <h2 class="text-2xl font-bold text-darkblue mt-2 text-center">{{ $user->name }}</h2>
                <p class="text-gray-500 font-semibold">{{ $user->username ?? $user->email }}</p>
            </div>

            <div class="w-full md:w-2/3 flex flex-col justify-center">

                <h3 class="text-xl font-bold text-gray-400 mb-6 border-b pb-3 flex items-center gap-2">
                    <i class="bi bi-person-lines-fill text-gray-300"></i> Informasi Akun Belajar
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                    <div class="bg-gray-50 p-5 rounded-2xl border border-gray-100">
                        <p class="text-sm text-gray-400 font-bold mb-1 flex items-center gap-2 uppercase tracking-wide">
                            <i class="bi bi-buildings text-[#12A0D7] text-lg"></i> Sekolah
                        </p>
                        <p class="font-bold text-darkblue text-lg mt-1">
                            {{ $user->school_name ?? 'Belajar Mandiri' }}
                        </p>
                    </div>

                    <div class="bg-gray-50 p-5 rounded-2xl border border-gray-100">
                        <p class="text-sm text-gray-400 font-bold mb-1 flex items-center gap-2 uppercase tracking-wide">
                            <i class="bi bi-easel text-[#05A660] text-lg"></i> Ruang Kelas
                        </p>
                        <p class="font-bold text-darkblue text-lg mt-1">
                            {{ $user->kelas ?? 'Belajar Mandiri' }}
                        </p>
                    </div>

                    <div class="bg-gray-50 p-5 rounded-2xl border border-gray-100">
                        <p class="text-sm text-gray-400 font-bold mb-1 flex items-center gap-2 uppercase tracking-wide">
                            <i class="bi bi-people text-orange text-lg"></i> Wali Murid
                        </p>
                        <p class="font-bold text-darkblue text-lg mt-1">
                            {{ \App\Models\User::find($user->parent_id)?->name ?? 'Belum Terhubung' }}
                        </p>
                    </div>

                    <div class="bg-linear-to-br from-[#FFF4E5] to-[#FEF5D3] p-5 rounded-2xl border border-[#FDECA6]">
                        <p class="text-sm text-orange font-bold mb-1 flex items-center gap-2 uppercase tracking-wide">
                            <i class="bi bi-trophy-fill text-lg"></i> Pencapaian
                        </p>
                        <div class="flex items-center gap-5 mt-2">
                            <div class="flex items-center gap-1.5" title="Total XP">
                                <span class="text-xl leading-none">⚡</span>
                                <span class="font-bold text-darkblue text-lg">{{ $user->xp ?? 0 }} XP</span>
                            </div>
                            <div class="flex items-center gap-1.5" title="Hari Beruntun">
                                <span class="text-xl leading-none">🔥</span>
                                <span class="font-bold text-darkblue text-lg">{{ $user->streak ?? 0 }} Hari</span>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>

        <div class="flex flex-wrap justify-center items-center gap-5 mt-10">
            <a href="{{ route('beranda') }}"
                class="bg-yellow text-darkblue font-bold px-8 py-3 rounded-full shadow-[0_4px_0_#d9b824] hover:-translate-y-1 hover:shadow-[0_6px_0_#d9b824] active:translate-y-1 active:shadow-[0_0px_0_#d9b824] transition-all no-underline flex items-center gap-3 text-lg">
                Kembali ke Beranda
            </a>
        </div>

    </div>
@endsection
