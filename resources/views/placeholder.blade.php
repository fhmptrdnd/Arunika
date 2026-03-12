@extends('layouts.app')

@section('content')
<style>
    .btn-back {
        display: inline-block;
        margin-top: 20px;
        padding: 10px 20px;
        background-color: var(--color-blue);
        color: white;
        text-decoration: none;
        border-radius: 10px;
        font-weight: bold;
    }
</style>

<div class="max-w-xl mt-40 rounded-2xl mx-auto px-5 pt-5 pb-5 flex flex-col items-center justify-between bg-white">
    <h1 style="color: var(--color-orange);" class="text-3xl font-bold">{{ $title }}</h1>
    <p>Halaman ini sedang dalam tahap pembangunan</p>

    <div style="background-color: var(--color-lightblue); padding: 50px; border-radius: 15px; border: 3px solid var(--color-teal); margin: 20px 0; color:black">
        <h2>Stay tune yah</h2>
    </div>
    <a href="{{ route('beranda') }}" class="btn-back">Kembali ke Beranda</a>
</div>

@endsection
