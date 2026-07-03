@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
    <div>
        <h1 class="page-title h2 mb-1">Dashboard</h1>
        <p class="text-secondary mb-0">Ringkasan data penjualan dan persediaan produk.</p>
    </div>
    <a href="{{ route('transactions.create') }}" class="btn btn-primary">+ Transaksi Baru</a>
</div>

<div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card h-100"><div class="card-body">
            <div class="text-secondary small">Kategori</div>
            <div class="stat-value">{{ $categoryCount }}</div>
        </div></div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card h-100"><div class="card-body">
            <div class="text-secondary small">Produk</div>
            <div class="stat-value">{{ $productCount }}</div>
        </div></div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card h-100"><div class="card-body">
            <div class="text-secondary small">Supplier</div>
            <div class="stat-value">{{ $supplierCount }}</div>
        </div></div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card h-100"><div class="card-body">
            <div class="text-secondary small">Transaksi</div>
            <div class="stat-value">{{ $transactionCount }}</div>
        </div></div>
    </div>
</div>

<div class="card mb-4">
    <div class="card-body d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2">
        <div>
            <div class="text-secondary small">Total Omzet</div>
            <div class="h3 fw-bold mb-0">Rp {{ number_format($revenue, 0, ',', '.') }}</div>
        </div>
        <span class="badge rounded-pill badge-soft-success px-3 py-2">Akumulasi seluruh transaksi</span>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-7">
        <div class="card h-100">
            <div class="card-header bg-white border-0 pt-4 px-4 d-flex justify-content-between">
                <h2 class="h5 fw-bold mb-0">Transaksi Terbaru</h2>
                <a href="{{ route('transactions.index') }}" class="small text-decoration-none">Lihat semua</a>
            </div>
            <div class="card-body px-0">
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead><tr><th class="ps-4">Invoice</th><th>Pelanggan</th><th>Total</th><th class="pe-4"></th></tr></thead>
                        <tbody>
                        @forelse ($latestTransactions as $transaction)
                            <tr>
                                <td class="ps-4 fw-semibold">{{ $transaction->invoice_number }}</td>
                                <td>{{ $transaction->customer_name }}</td>
                                <td>Rp {{ number_format($transaction->total, 0, ',', '.') }}</td>
                                <td class="text-end pe-4"><a href="{{ route('transactions.show', $transaction) }}" class="btn btn-sm btn-outline-primary">Detail</a></td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="empty-state">Belum ada transaksi.</td></tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="card h-100">
            <div class="card-header bg-white border-0 pt-4 px-4">
                <h2 class="h5 fw-bold mb-0">Stok Menipis</h2>
            </div>
            <div class="card-body">
                @forelse ($lowStockProducts as $product)
                    <div class="d-flex justify-content-between align-items-center py-2 border-bottom">
                        <div>
                            <div class="fw-semibold">{{ $product->name }}</div>
                            <div class="small text-secondary">{{ $product->category->name }}</div>
                        </div>
                        <span class="badge {{ $product->stock === 0 ? 'text-bg-danger' : 'text-bg-warning' }}">{{ $product->stock }} unit</span>
                    </div>
                @empty
                    <div class="empty-state">Semua stok masih aman.</div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
