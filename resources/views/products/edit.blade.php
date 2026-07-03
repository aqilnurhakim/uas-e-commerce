@extends('layouts.app')
@section('title', 'Edit Produk')
@section('content')
<div class="mb-4"><h1 class="page-title h2 mb-1">Edit Produk</h1><p class="text-secondary mb-0">Perbarui data {{ $product->name }}.</p></div>
<div class="card"><div class="card-body p-4">
<form action="{{ route('products.update', $product) }}" method="POST">@csrf @method('PUT') @include('products._form', ['buttonText' => 'Perbarui Produk'])</form>
</div></div>
@endsection
