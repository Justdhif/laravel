<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;


class UserController extends Controller
{
    public function searchMenu(Request $request)
    {
        $query = $request->input('query'); // Kata kunci pencarian
        $category = $request->input('category_name'); // Filter kategori (opsional)

        // Simpan riwayat pencarian ke session
        if ($query) {
            $searchHistory = $request->session()->get('search_history', []);
            if (!in_array($query, $searchHistory)) {
                array_unshift($searchHistory, $query); // Tambahkan ke awal array
                $searchHistory = array_slice($searchHistory, 0, 5); // Batasi 5 riwayat terbaru
                $request->session()->put('search_history', $searchHistory);
            }
        }

        // Query pencarian
        $menus = Menu::query()
            ->when($query, function ($queryBuilder) use ($query) {
                return $queryBuilder->where('name', 'LIKE', "%$query%")
                                    ->orWhere('description', 'LIKE', "%$query%");
            })
            ->when($category, function ($queryBuilder) use ($category) {
                return $queryBuilder->where('category', $category);
            })
            ->inRandomOrder()
            ->limit(12)
            ->get();

        // Ambil semua kategori unik untuk filter
        $categories = Menu::select('category_id')->distinct()->pluck('category_id');

        // Ambil riwayat pencarian dari session
        $searchHistory = $request->session()->get('search_history', []);

        return view('search', compact('menus', 'categories', 'query', 'category', 'searchHistory'));
    }

    public function clearSearchHistory()
    {
        // Menghapus data riwayat pencarian dari session
        Session::forget('search_history');

        // Redirect kembali ke halaman pencarian dengan pesan sukses
        return redirect()->route('menu.search')->with('success', 'Riwayat pencarian berhasil dihapus.');
    }

    public function landingPage()
    {
        $menus = Menu::orderBy('created_at', 'asc')->take(4)->get();
        return view('landing_page', compact('menus'));
    }

    public function processTopUp(Request $request)
    {
        $request->validate([
            'nominal' => 'required|numeric|min:10000|max:1000000', // Batas nominal isi saldo
        ]);

        $user = Auth::user();
        $user->saldo += $request->input('nominal'); // Tambahkan saldo
        $user->save();

        return redirect()->route('home.show')->with('success', 'Saldo berhasil ditambahkan!');
    }
}
