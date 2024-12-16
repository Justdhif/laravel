<?php

// app/Http/Controllers/Admin/TransactionController.php

namespace App\Http\Controllers\Admin;

use App\Models\Transaction;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function showTransaction($id)
    {
        $transaction = Transaction::with('items')->findOrFail($id);

        // Pastikan item tidak kosong
        if ($transaction->items->isEmpty()) {
            return redirect()->back()->with('error', 'Transaksi ini tidak memiliki item.');
        }

        // Kirim data ke view
        return view('admin.transaction-detail', compact('transaction'));
    }

    public function showOrderPage($id)
    {
        $orders = Transaction::where('user_id', Auth::id())
        ->with('items.menu') // Memuat relasi items dan menu
        ->get();

        return view('order-page', compact('orders'));
    }
}
