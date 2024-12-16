<?php

namespace App\Http\Controllers\Auth;

use App\Models\Cart;
use App\Models\Menu;
use App\Models\User;
use App\Models\Ratings;
use App\Models\Category;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'role' => ['required', Rule::in(['admin', 'pembeli'])],
            'profile_pic' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $profilePicPath = $request->file('profile_pic')
        ? $request->file('profile_pic')->store('images/profile', 'public')
        : 'images/profile/default-profile.png';

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'profile_pic' => $profilePicPath, // Kosong jika tidak ada gambar diunggah
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('login')->with('success', 'Registrasi berhasil.');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->route('home.show');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout(); // Logout user
        $request->session()->invalidate(); // Hapus session
        $request->session()->regenerateToken(); // Regenerate CSRF token

        return redirect('/login'); // Redirect ke halaman login
    }

    public function showHome()
    {
        $user = Auth::user();
        $categories = Category::all();
        $totalCart = Cart::count();
        $totalWishlist = Wishlist::count();

        // Periksa apakah user memiliki Paket 3
        $isPremium3 = $user->premiumPackages()
            ->wherePivot('premium_expires_at', '>', now())
            ->where('premium_packages.id', 3) // Spesifikasikan tabel
            ->exists();

        // Ambil menu dengan diskon jika user memiliki Paket 3
        $menus = Menu::with('vouchers', 'ratings')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($menu) use ($isPremium3) {
                $menu->average_rating = $menu->ratings->avg('rating') ?: 0;
                $menu->review_count = $menu->ratings->count();

                if ($isPremium3) {
                    $menu->discount_price = $menu->price * 0.8; // Diskon 20%
                } else {
                    $menu->discount_price = null;
                }

                return $menu;
            });

        return view('home', compact('menus', 'categories', 'totalCart', 'totalWishlist'));
    }
}
