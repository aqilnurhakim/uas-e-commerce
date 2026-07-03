@extends('layouts.app')
@section('title', 'Edit Kategori')
@section('content')
<div class="mb-4"><h1 class="page-title h2 mb-1">Edit Kategori</h1><p class="text-secondary mb-0">Perbarui data {{ $category->name }}.</p></div>
<div class="card"><div class="card-body p-4">
    <form action="{{ route('categories.update', $category) }}" method="POST">
        @csrf @method('PUT')
        @include('categories._form', ['buttonText' => 'Perbarui Kategori'])
    </form>
</div></div>
@endsection
