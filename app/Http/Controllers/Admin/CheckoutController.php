<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Voucher;
use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function processCheckout(Request $request)
    {
        $user = Auth::user();
        $cartItems = Cart::with('menu')->where('user_id', $user->id)->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang Anda kosong.');
        }

        $totalPrice = 0;

        foreach ($cartItems as $item) {
            $menu = $item->menu;

            if ($menu->stock < $item->quantity) {
                return redirect()->route('cart.index')->with(
                    'error',
                    "Stok untuk menu '{$menu->name}' tidak mencukupi."
                );
            }

            $totalPrice += $menu->price * $item->quantity;
        }

        // Hitung diskon berdasarkan status premium
        $discount = 0;

        if ($user->is_premium) {
            if ($user->premium_badge === null) {
                $discount = rand(5, 15); // Diskon random untuk Paket 1
            } elseif ($user->premium_badge === 'Premium Badge') {
                $discount = 20; // Diskon tetap untuk Paket 2 & 3
            }
        }

        $discountAmount = $totalPrice * ($discount / 100);
        $finalPrice = $totalPrice - $discountAmount;

        if ($user->saldo < $finalPrice) {
            return redirect()->route('cart.index')->with('error', 'Saldo Anda tidak mencukupi.');
        }

        // Buat transaksi
        $transaction = Transaction::create([
            'user_id' => $user->id,
            'total_price' => $totalPrice,
            'discount' => $discount, // Simpan persentase diskon
            'final_price' => $finalPrice, // Simpan harga setelah diskon
        ]);

        foreach ($cartItems as $item) {
            $menu = $item->menu;

            TransactionItem::create([
                'transaction_id' => $transaction->id,
                'menu_id' => $menu->id,
                'quantity' => $item->quantity,
                'price' => $menu->price * $item->quantity,
            ]);

            $menu->decrement('stock', $item->quantity);
            $menu->increment('sold', $item->quantity);
        }

        $user->decrement('saldo', $finalPrice);
        Cart::where('user_id', $user->id)->delete();

        return redirect()->route('transactions.show', $transaction->id)
            ->with('success', "Checkout berhasil! Diskon sebesar {$discount}% telah diterapkan.");
    }

}
