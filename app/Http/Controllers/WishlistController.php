<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    // Menambahkan menu ke dalam wishlist
    public function addWishlist($menuId)
    {
        $menu = Menu::findOrFail($menuId);

        // Cek apakah menu sudah ada di wishlist user
        $existingWishlist = Wishlist::where('user_id', Auth::id())
                                    ->where('menu_id', $menuId)
                                    ->first();

        if ($existingWishlist) {
            return redirect()->back()->with('info', 'Menu sudah ada di wishlist Anda!');
        }

        // Tambahkan menu ke wishlist
        Wishlist::create([
            'user_id' => Auth::id(),
            'menu_id' => $menuId,
        ]);

        return redirect()->back()->with('success', 'Menu berhasil ditambahkan ke wishlist!');
    }

    // Menampilkan wishlist user
    public function showWishlist()
    {
        // Ambil daftar menu yang ada di wishlist user
        $wishlists = Wishlist::where('user_id', Auth::id())->with([
            'menu' => function ($query) {
                $query->withAvg('ratings', 'rating') // Mengambil rata-rata rating
                      ->withCount('ratings');       // Menghitung jumlah ulasan
            }
        ])->where('user_id', Auth::id())->get();

        return view('wishlist', compact('wishlists'));
    }

    // Menghapus menu dari wishlist
    public function removeWishlist($menuId)
    {
        $menu = Menu::findOrFail($menuId);

        // Hapus menu dari wishlist
        Wishlist::where('user_id', Auth::id())
                ->where('menu_id', $menuId)
                ->delete();

        return redirect()->back()->with('success', 'Menu berhasil dihapus dari wishlist!');
    }

    public function isMenuInWishlist($menuId)
    {
        $user = Auth::user();

        // Cek apakah menu ada di wishlist user
        return Wishlist::where('user_id', $user->id)
                    ->where('menu_id', $menuId)
                    ->exists();
    }
}
