@extends('layouts.app')
@section('title', 'Produk')
@section('content')
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
    <div><h1 class="page-title h2 mb-1">Produk</h1><p class="text-secondary mb-0">Kelola produk, harga, dan persediaan.</p></div>
    @if (session('auth_user_role') === 'admin')
        <a href="{{ route('products.create') }}" class="btn btn-primary">+ Tambah Produk</a>
    @endif
</div>
<div class="card">
    <div class="card-body border-bottom">
        <form class="row g-2" method="GET">
            <div class="col-md-7"><input name="q" value="{{ request('q') }}" class="form-control" placeholder="Cari nama atau SKU..."></div>
            <div class="col-md-3">
                <select name="category_id" class="form-select">
                    <option value="">Semua kategori</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @selected(request('category_id') == $category->id)>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2 d-grid"><button class="btn btn-outline-primary">Filter</button></div>
        </form>
    </div>
    <div class="table-responsive">
        <table class="table mb-0">
            <thead><tr><th class="ps-4">SKU</th><th>Produk</th><th>Kategori</th><th>Supplier</th><th>Harga</th><th>Stok</th>@if (session('auth_user_role') === 'admin')<th class="text-end pe-4">Aksi</th>@endif</tr></thead>
            <tbody>
            @forelse ($products as $product)
                <tr>
                    <td class="ps-4"><span class="badge text-bg-light border">{{ $product->sku }}</span></td>
                    <td><div class="fw-semibold">{{ $product->name }}</div><div class="small text-secondary">{{ \Illuminate\Support\Str::limit($product->description ?: '-', 45) }}</div></td>
                    <td>{{ $product->category->name }}</td>
                    <td>{{ $product->supplier->name }}</td>
                    <td class="fw-semibold">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                    <td><span class="badge {{ $product->stock <= 5 ? 'text-bg-warning' : 'badge-soft-success' }}">{{ $product->stock }}</span></td>
                    @if (session('auth_user_role') === 'admin')
                        <td class="text-end pe-4">
                            <a href="{{ route('products.edit', $product) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                            <form action="{{ route('products.destroy', $product) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus produk ini?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">Hapus</button>
                            </form>
                        </td>
                    @endif
                </tr>
            @empty
                <tr><td colspan="{{ session('auth_user_role') === 'admin' ? 7 : 6 }}" class="empty-state">Data produk belum tersedia.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    @if ($products->hasPages())<div class="card-footer bg-white">{{ $products->links() }}</div>@endif
</div>
@endsection
