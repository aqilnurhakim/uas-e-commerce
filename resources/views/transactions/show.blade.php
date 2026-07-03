@extends('layouts.app')
@section('title', 'Detail Transaksi')
@section('content')
<div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4 no-print">
    <div><h1 class="page-title h2 mb-1">Detail Transaksi</h1><p class="text-secondary mb-0">Informasi invoice dan item penjualan.</p></div>
    <div class="d-flex gap-2">
        <button onclick="window.print()" class="btn btn-outline-primary">Cetak</button>
        <a href="{{ route('transactions.index') }}" class="btn btn-light border">Kembali</a>
    </div>
</div>

<div class="card"><div class="card-body p-4 p-lg-5">
    <div class="d-flex flex-column flex-md-row justify-content-between gap-4 mb-4">
        <div>
            <div class="text-primary fw-bold fs-4">E-Commerce Mandala</div>
            <div class="text-secondary">Aplikasi Penjualan Produk</div>
        </div>
        <div class="invoice-box">
            <div class="small text-secondary">Nomor Invoice</div>
            <div class="fw-bold">{{ $transaction->invoice_number }}</div>
            <div class="small text-secondary mt-2">Tanggal</div>
            <div>{{ $transaction->transaction_date->format('d F Y') }}</div>
        </div>
    </div>

    <div class="mb-4">
        <div class="small text-secondary">Pelanggan</div>
        <div class="fw-bold fs-5">{{ $transaction->customer_name }}</div>
    </div>

    <div class="table-responsive">
        <table class="table align-middle">
            <thead><tr><th>No</th><th>Produk</th><th>Kategori</th><th class="text-end">Harga</th><th class="text-center">Jumlah</th><th class="text-end">Subtotal</th></tr></thead>
            <tbody>
            @foreach ($transaction->details as $detail)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td><div class="fw-semibold">{{ $detail->product->name }}</div><div class="small text-secondary">{{ $detail->product->sku }}</div></td>
                    <td>{{ $detail->product->category->name }}</td>
                    <td class="text-end">Rp {{ number_format($detail->price, 0, ',', '.') }}</td>
                    <td class="text-center">{{ $detail->quantity }}</td>
                    <td class="text-end fw-semibold">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                </tr>
            @endforeach
            </tbody>
            <tfoot><tr><th colspan="5" class="text-end fs-5">Total</th><th class="text-end fs-5 text-primary">Rp {{ number_format($transaction->total, 0, ',', '.') }}</th></tr></tfoot>
        </table>
    </div>

    <div class="text-secondary small mt-4">Terima kasih telah melakukan transaksi.</div>
</div></div>
@endsection
