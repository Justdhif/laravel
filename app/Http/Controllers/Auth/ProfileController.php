<?php

namespace App\Http\Controllers\Auth;

use App\Models\Cart;
use App\Models\Menu;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function showProfile()
    {
        $orderCount = Transaction::count();
        $totalMenus = Menu::where('user_id', Auth::user()->id)->with('ratings')->count();

        return view('profile.profile', compact('orderCount', 'totalMenus'));
    }

    public function profileUpdate(Request $request)
    {
        $user = Auth::user();

        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'bio' => 'nullable|string|max:500',
            'profile_pic' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Simpan foto profil baru jika ada
        if ($request->hasFile('profile_pic')) {
            if ($user->profile_pic) {
                Storage::delete($user->profile_pic);
            }
            $path = $request->file('profile_pic')->store('images/profile', 'public');
            $user->profile_pic = $path;
        }

        // Update nama dan bio
        $user->name = $request->name;
        $user->bio = $request->bio;

        // Simpan perubahan
        $user->save();

        return redirect()->route('profile.show')->with('success', 'Profil berhasil diperbarui.');
    }

    public function showYourMenu() {
        $menus = Menu::where('user_id', Auth::user()->id)->with('ratings')->get();

        $totalMenus = $menus->count();
        $totalReviews = $menus->sum(fn($menu) => $menu->ratings->count());
        $averageRating = $menus->flatMap(fn($menu) => $menu->ratings->pluck('rating'))->average();
        $orderCount = Transaction::count();

        return view('profile.your-menu', compact( 'menus', 'totalMenus', 'totalReviews', 'averageRating', 'orderCount'));
    }

    public function showYourOrder() {
        $orders = Transaction::where('user_id', Auth::user()->id)->with('items.menu')->get();
        $cartCount = Cart::where('user_id', Auth::user()->id)->count();
        $orderCount = $orders->count();
        $totalMenus = Menu::where('user_id', Auth::user()->id)->with('ratings')->count();

        return view('profile.your_order', compact('orders', 'cartCount', 'orderCount', 'totalMenus'));
    }
}
