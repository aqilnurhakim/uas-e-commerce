@extends('layouts.app')
@section('title', 'Transaksi')
@section('content')
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
    <div><h1 class="page-title h2 mb-1">Transaksi</h1><p class="text-secondary mb-0">Riwayat penjualan produk.</p></div>
    <a href="{{ route('transactions.create') }}" class="btn btn-primary">+ Transaksi Baru</a>
</div>
<div class="card">
    <div class="card-body border-bottom">
        <form class="row g-2" method="GET">
            <div class="col-md-10"><input name="q" value="{{ request('q') }}" class="form-control" placeholder="Cari invoice atau nama pelanggan..."></div>
            <div class="col-md-2 d-grid"><button class="btn btn-outline-primary">Cari</button></div>
        </form>
    </div>
    <div class="table-responsive">
        <table class="table mb-0">
            <thead><tr><th class="ps-4">Invoice</th><th>Tanggal</th><th>Pelanggan</th><th>Item</th><th>Total</th><th class="text-end pe-4">Aksi</th></tr></thead>
            <tbody>
            @forelse ($transactions as $transaction)
                <tr>
                    <td class="ps-4 fw-semibold">{{ $transaction->invoice_number }}</td>
                    <td>{{ $transaction->transaction_date->format('d/m/Y') }}</td>
                    <td>{{ $transaction->customer_name }}</td>
                    <td><span class="badge badge-soft-primary">{{ $transaction->details_count }} item</span></td>
                    <td class="fw-semibold">Rp {{ number_format($transaction->total, 0, ',', '.') }}</td>
                    <td class="text-end pe-4">
                        <a href="{{ route('transactions.show', $transaction) }}" class="btn btn-sm btn-outline-primary">Detail</a>
                        @if (session('auth_user_role') === 'admin')
                            <form action="{{ route('transactions.destroy', $transaction) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus transaksi ini? Stok produk akan dikembalikan.')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">Hapus</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="empty-state">Belum ada transaksi penjualan.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
    @if ($transactions->hasPages())<div class="card-footer bg-white">{{ $transactions->links() }}</div>@endif
</div>
@endsection
