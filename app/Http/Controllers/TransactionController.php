<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class TransactionController extends Controller
{
    public function index(Request $request): View
    {
        $query = Transaction::withCount('details')->latest('transaction_date')->latest('id');

        if ($request->filled('q')) {
            $keyword = $request->string('q');
            $query->where(function ($builder) use ($keyword) {
                $builder->where('invoice_number', 'like', '%'.$keyword.'%')
                    ->orWhere('customer_name', 'like', '%'.$keyword.'%');
            });
        }

        return view('transactions.index', [
            'transactions' => $query->paginate(10)->withQueryString(),
        ]);
    }

    public function create(): View
    {
        return view('transactions.create', [
            'products' => Product::with('category')
                ->where('stock', '>', 0)
                ->orderBy('name')
                ->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'transaction_date' => ['required', 'date'],
            'customer_name' => ['required', 'string', 'max:120'],
            'product_id' => ['required', 'array', 'min:1'],
            'product_id.*' => ['required', 'integer', 'distinct', 'exists:products,id'],
            'quantity' => ['required', 'array', 'min:1'],
            'quantity.*' => ['required', 'integer', 'min:1'],
        ]);

        if (count($validated['product_id']) !== count($validated['quantity'])) {
            throw ValidationException::withMessages([
                'product_id' => 'Jumlah baris produk dan jumlah pembelian tidak sesuai.',
            ]);
        }

        $transaction = DB::transaction(function () use ($validated) {
            $transaction = Transaction::create([
                'invoice_number' => $this->generateInvoiceNumber(),
                'transaction_date' => $validated['transaction_date'],
                'customer_name' => $validated['customer_name'],
                'total' => 0,
            ]);

            $total = 0;

            foreach ($validated['product_id'] as $index => $productId) {
                $product = Product::query()->lockForUpdate()->findOrFail($productId);
                $quantity = (int) $validated['quantity'][$index];

                if ($product->stock < $quantity) {
                    throw ValidationException::withMessages([
                        "quantity.$index" => "Stok {$product->name} hanya tersisa {$product->stock}.",
                    ]);
                }

                $subtotal = (float) $product->price * $quantity;

                $transaction->details()->create([
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'price' => $product->price,
                    'subtotal' => $subtotal,
                ]);

                $product->decrement('stock', $quantity);
                $total += $subtotal;
            }

            $transaction->update(['total' => $total]);

            return $transaction;
        });

        return redirect()->route('transactions.show', $transaction)
            ->with('success', 'Transaksi berhasil disimpan dan stok produk telah diperbarui.');
    }

    public function show(Transaction $transaction): View
    {
        $transaction->load(['details.product.category']);

        return view('transactions.show', compact('transaction'));
    }

    public function destroy(Transaction $transaction): RedirectResponse
    {
        DB::transaction(function () use ($transaction) {
            $transaction->load('details');

            foreach ($transaction->details as $detail) {
                Product::query()
                    ->whereKey($detail->product_id)
                    ->increment('stock', $detail->quantity);
            }

            $transaction->delete();
        });

        return redirect()->route('transactions.index')
            ->with('success', 'Transaksi dihapus dan stok produk dikembalikan.');
    }

    private function generateInvoiceNumber(): string
    {
        do {
            $invoice = 'TRX-'.now()->format('Ymd-His').'-'.random_int(100, 999);
        } while (Transaction::where('invoice_number', $invoice)->exists());

        return $invoice;
    }
}
