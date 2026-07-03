@extends('layouts.app')
@section('title', 'Edit Supplier')
@section('content')
<div class="mb-4"><h1 class="page-title h2 mb-1">Edit Supplier</h1><p class="text-secondary mb-0">Perbarui data {{ $supplier->name }}.</p></div>
<div class="card"><div class="card-body p-4">
<form action="{{ route('suppliers.update', $supplier) }}" method="POST">@csrf @method('PUT') @include('suppliers._form', ['buttonText' => 'Perbarui Supplier'])</form>
</div></div>
@endsection
