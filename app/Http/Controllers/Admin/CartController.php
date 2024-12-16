<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Menu;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function showCartPage()
    {
        $cartItems = Cart::where('user_id', auth()->id())->with('menu')->get();
        $vouchers = Voucher::all();
        return view('admin.cart', compact('cartItems', 'vouchers'));
    }

    public function addToCart(Request $request, $menuId)
    {
        $menu = Menu::findOrFail($menuId);

        // Cek jika menu sudah ada di keranjang
        $cartItem = Cart::where('user_id', Auth::id())->where('menu_id', $menu->id)->first();
        if ($cartItem) {
            $cartItem->quantity += $request->quantity;
            $cartItem->save();
        } else {
            Cart::create([
                'user_id' => Auth::id(),
                'menu_id' => $menu->id,
                'quantity' => $request->quantity,
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Menu berhasil ditambahkan ke keranjang.');
    }

    public function removeFromCart($id)
    {
        $cartItem = Cart::where('user_id', Auth::id())->findOrFail($id);
        $cartItem->delete();

        return redirect()->route('cart.index')->with('success', 'Menu berhasil dihapus dari keranjang.');
    }
}

