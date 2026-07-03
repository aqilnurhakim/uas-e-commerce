@extends('layouts.app')
@section('title', 'Kategori')
@section('content')
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
    <div><h1 class="page-title h2 mb-1">Kategori</h1><p class="text-secondary mb-0">Kelola pengelompokan produk.</p></div>
    <a href="{{ route('categories.create') }}" class="btn btn-primary">+ Tambah Kategori</a>
</div>

<div class="card">
    <div class="card-body border-bottom">
        <form class="row g-2" method="GET">
            <div class="col-md-10"><input name="q" value="{{ request('q') }}" class="form-control" placeholder="Cari nama kategori..."></div>
            <div class="col-md-2 d-grid"><button class="btn btn-outline-primary">Cari</button></div>
        </form>
    </div>
    <div class="table-responsive">
        <table class="table mb-0">
            <thead><tr><th class="ps-4">No</th><th>Nama</th><th>Deskripsi</th><th>Jumlah Produk</th><th class="text-end pe-4">Aksi</th></tr></thead>
            <tbody>
            @forelse ($categories as $category)
                <tr>
                    <td class="ps-4">{{ $categories->firstItem() + $loop->index }}</td>
                    <td class="fw-semibold">{{ $category->name }}</td>
                    <td class="text-secondary">{{ \Illuminate\Support\Str::limit($category->description ?: '-', 70) }}</td>
                    <td><span class="badge badge-soft-primary">{{ $category->products_count }} produk</span></td>
                    <td class="text-end pe-4">
                        <a href="{{ route('categories.edit', $category) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                        <form action="{{ route('categories.destroy', $category) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus kategori ini?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="empty-state">Data kategori belum tersedia.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    @if ($categories->hasPages())
        <div class="card-footer bg-white">{{ $categories->links() }}</div>
    @endif
</div>
@endsection
