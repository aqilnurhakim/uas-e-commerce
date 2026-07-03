@extends('layouts.app')
@section('title', 'Tambah Kategori')
@section('content')
<div class="mb-4"><h1 class="page-title h2 mb-1">Tambah Kategori</h1><p class="text-secondary mb-0">Masukkan data kategori baru.</p></div>
<div class="card"><div class="card-body p-4">
    <form action="{{ route('categories.store') }}" method="POST">
        @csrf
        @include('categories._form', ['buttonText' => 'Simpan Kategori'])
    </form>
</div></div>
@endsection
