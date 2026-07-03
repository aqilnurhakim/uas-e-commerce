<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\Transaction;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        return view('dashboard', [
            'categoryCount' => Category::count(),
            'productCount' => Product::count(),
            'supplierCount' => Supplier::count(),
            'transactionCount' => Transaction::count(),
            'revenue' => Transaction::sum('total'),
            'lowStockProducts' => Product::with(['category', 'supplier'])
                ->where('stock', '<=', 5)
                ->orderBy('stock')
                ->take(5)
                ->get(),
            'latestTransactions' => Transaction::latest('transaction_date')
                ->latest('id')
                ->take(5)
                ->get(),
        ]);
    }
}
