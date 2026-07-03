@extends('layouts.app')
@section('title', 'Transaksi Baru')
@section('content')
<div class="mb-4"><h1 class="page-title h2 mb-1">Transaksi Baru</h1><p class="text-secondary mb-0">Pilih produk dan jumlah pembelian. Stok berkurang otomatis setelah disimpan.</p></div>

@if ($products->isEmpty())
    <div class="alert alert-warning">Tidak ada produk yang memiliki stok. Tambahkan atau perbarui stok terlebih dahulu.</div>
@endif

<form action="{{ route('transactions.store') }}" method="POST" id="transactionForm">
    @csrf
    <div class="card mb-4"><div class="card-body p-4">
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label fw-semibold">Tanggal Transaksi</label>
                <input type="date" name="transaction_date" class="form-control" value="{{ old('transaction_date', now()->format('Y-m-d')) }}" required>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Nama Pelanggan</label>
                <input type="text" name="customer_name" class="form-control" value="{{ old('customer_name') }}" placeholder="Contoh: Budi Santoso" required>
            </div>
        </div>
    </div></div>

    <div class="card">
        <div class="card-header bg-white border-0 pt-4 px-4 d-flex justify-content-between align-items-center">
            <h2 class="h5 fw-bold mb-0">Daftar Produk</h2>
            <button type="button" class="btn btn-sm btn-outline-primary" id="addRow" @disabled($products->isEmpty())>+ Tambah Baris</button>
        </div>
        <div class="card-body p-4">
            <div id="itemRows"></div>
            <div class="border-top pt-3 mt-3 d-flex justify-content-end">
                <div class="text-end">
                    <div class="text-secondary">Estimasi Total</div>
                    <div class="h3 fw-bold mb-0" id="grandTotal">Rp 0</div>
                </div>
            </div>
            <div class="d-flex gap-2 mt-4">
                <button class="btn btn-primary" @disabled($products->isEmpty())>Simpan Transaksi</button>
                <a href="{{ route('transactions.index') }}" class="btn btn-light border">Batal</a>
            </div>
        </div>
    </div>
</form>

<template id="itemTemplate">
    <div class="row g-2 align-items-end item-row border-bottom pb-3 mb-3">
        <div class="col-lg-7">
            <label class="form-label fw-semibold">Produk</label>
            <select name="product_id[]" class="form-select product-select" required>
                <option value="">Pilih produk</option>
                @foreach ($products as $product)
                    <option value="{{ $product->id }}" data-price="{{ $product->price }}" data-stock="{{ $product->stock }}">
                        {{ $product->name }} • {{ $product->sku }} • stok {{ $product->stock }} • Rp {{ number_format($product->price, 0, ',', '.') }}
                    </option>
                @endforeach
            </select>
            <div class="form-text stock-info"></div>
        </div>
        <div class="col-lg-2">
            <label class="form-label fw-semibold">Jumlah</label>
            <input type="number" name="quantity[]" min="1" value="1" class="form-control quantity-input" required>
        </div>
        <div class="col-lg-2">
            <label class="form-label fw-semibold">Subtotal</label>
            <input type="text" class="form-control subtotal-display" value="Rp 0" readonly>
        </div>
        <div class="col-lg-1 d-grid">
            <button type="button" class="btn btn-outline-danger remove-row">×</button>
        </div>
    </div>
</template>
@endsection

@push('scripts')
<script>
    const rowsContainer = document.getElementById('itemRows');
    const template = document.getElementById('itemTemplate');
    const addRowButton = document.getElementById('addRow');
    const grandTotal = document.getElementById('grandTotal');
    const rupiah = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 });

    function updateTotals() {
        let total = 0;
        document.querySelectorAll('.item-row').forEach(row => {
            const select = row.querySelector('.product-select');
            const selected = select.options[select.selectedIndex];
            const price = Number(selected?.dataset.price || 0);
            const stock = Number(selected?.dataset.stock || 0);
            const quantityInput = row.querySelector('.quantity-input');
            const quantity = Number(quantityInput.value || 0);
            const subtotal = price * quantity;

            row.querySelector('.subtotal-display').value = rupiah.format(subtotal);
            row.querySelector('.stock-info').textContent = selected?.value ? `Stok tersedia: ${stock}` : '';
            quantityInput.max = stock || '';
            total += subtotal;
        });

        grandTotal.textContent = rupiah.format(total);
    }

    function addRow() {
        const fragment = template.content.cloneNode(true);
        const row = fragment.querySelector('.item-row');
        row.querySelector('.product-select').addEventListener('change', updateTotals);
        row.querySelector('.quantity-input').addEventListener('input', updateTotals);
        row.querySelector('.remove-row').addEventListener('click', () => {
            row.remove();
            updateTotals();
        });
        rowsContainer.appendChild(fragment);
        updateTotals();
    }

    addRowButton?.addEventListener('click', addRow);

    @if (!$products->isEmpty())
        addRow();
    @endif
</script>
@endpush
