@extends('layouts.app')
@section('title', 'Supplier')
@section('content')
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
    <div><h1 class="page-title h2 mb-1">Supplier</h1><p class="text-secondary mb-0">Kelola data pemasok produk.</p></div>
    <a href="{{ route('suppliers.create') }}" class="btn btn-primary">+ Tambah Supplier</a>
</div>
<div class="card">
    <div class="card-body border-bottom">
        <form class="row g-2" method="GET">
            <div class="col-md-10"><input name="q" value="{{ request('q') }}" class="form-control" placeholder="Cari nama, email, atau telepon..."></div>
            <div class="col-md-2 d-grid"><button class="btn btn-outline-primary">Cari</button></div>
        </form>
    </div>
    <div class="table-responsive">
        <table class="table mb-0">
            <thead><tr><th class="ps-4">No</th><th>Supplier</th><th>Kontak</th><th>Alamat</th><th>Produk</th><th class="text-end pe-4">Aksi</th></tr></thead>
            <tbody>
            @forelse ($suppliers as $supplier)
                <tr>
                    <td class="ps-4">{{ $suppliers->firstItem() + $loop->index }}</td>
                    <td class="fw-semibold">{{ $supplier->name }}</td>
                    <td><div>{{ $supplier->phone }}</div><div class="small text-secondary">{{ $supplier->email ?: '-' }}</div></td>
                    <td class="text-secondary">{{ \Illuminate\Support\Str::limit($supplier->address, 55) }}</td>
                    <td><span class="badge badge-soft-primary">{{ $supplier->products_count }} produk</span></td>
                    <td class="text-end pe-4">
                        <a href="{{ route('suppliers.edit', $supplier) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                        <form action="{{ route('suppliers.destroy', $supplier) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus supplier ini?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="empty-state">Data supplier belum tersedia.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    @if ($suppliers->hasPages())<div class="card-footer bg-white">{{ $suppliers->links() }}</div>@endif
</div>
@endsection
