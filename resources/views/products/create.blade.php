@extends('layouts.app')
@section('title', 'Tambah Produk')
@section('content')
<div class="mb-4"><h1 class="page-title h2 mb-1">Tambah Produk</h1><p class="text-secondary mb-0">Masukkan produk baru beserta kategori dan supplier.</p></div>
@if ($categories->isEmpty() || $suppliers->isEmpty())
    <div class="alert alert-warning">Tambahkan minimal satu kategori dan satu supplier sebelum menyimpan produk.</div>
@endif
<div class="card"><div class="card-body p-4">
<form action="{{ route('products.store') }}" method="POST">@csrf @include('products._form', ['buttonText' => 'Simpan Produk'])</form>
</div></div>
@endsection
