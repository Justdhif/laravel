<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class TrackController extends Controller
{
    public function showTrack()
    {
        // Penjualan per bulan (Diagram Garis)
        $salesPerMonth = DB::table('transaction_items')
            ->join('transactions', 'transaction_items.transaction_id', '=', 'transactions.id')
            ->selectRaw('MONTH(transactions.created_at) as month, SUM(transaction_items.quantity) as total_quantity')
            ->groupByRaw('MONTH(transactions.created_at)')
            ->pluck('total_quantity', 'month');

        // Pemasukan dan Pengeluaran (Diagram Batang)
        $incomePerMonth = DB::table('transactions')
            ->selectRaw('MONTH(created_at) as month, SUM(total_price) as total_income')
            ->groupByRaw('MONTH(created_at)')
            ->pluck('total_income', 'month');

        $expensePerMonth = DB::table('menus')
            ->join('transaction_items', 'menus.id', '=', 'transaction_items.menu_id')
            ->selectRaw('MONTH(transaction_items.created_at) as month, SUM(menus.stock * menus.price) as total_expense')
            ->groupByRaw('MONTH(transaction_items.created_at)')
            ->pluck('total_expense', 'month');

        // Persentase Penjualan per Menu (Diagram Lingkaran)
        $salesPerMenu = DB::table('transaction_items')
            ->join('menus', 'transaction_items.menu_id', '=', 'menus.id')
            ->selectRaw('menus.name as menu_name, SUM(transaction_items.quantity) as total_sold')
            ->groupBy('menus.name')
            ->pluck('total_sold', 'menu_name');

        // Konversi bulan ke nama bulan
        $months = collect(range(1, 12))->map(function ($month) {
            return Carbon::create()->month($month)->format('F');
        });

        return view('admin.track', compact('salesPerMonth', 'incomePerMonth', 'expensePerMonth', 'salesPerMenu', 'months'));
    }
}
