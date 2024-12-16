<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PremiumPackage;
use Illuminate\Support\Facades\Auth;

class PremiumController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $packages = PremiumPackage::all();

        // Ambil paket premium aktif dari pivot
        $premiumPackage = $user->premiumPackages()
            ->wherePivot('premium_expires_at', '>', now())
            ->latest('pivot_premium_expires_at')
            ->first();

        return view('premium', compact('packages', 'premiumPackage'));
    }

    public function purchase(Request $request, $packageId)
    {
        $user = Auth::user();
        $newPackage = PremiumPackage::findOrFail($packageId);

        // Ambil paket premium aktif
        $activePackage = $user->premiumPackages()
            ->wherePivot('premium_expires_at', '>', now()) // Cek jika masa berlaku masih aktif
            ->latest('pivot_premium_expires_at') // Ambil paket aktif terakhir
            ->first();

        // Cek level paket baru lebih rendah
        if ($activePackage && $newPackage->level <= $activePackage->level) {
            return redirect()->route('premium.index')->with(
                'error',
                'Anda tidak dapat membeli paket dengan level lebih rendah dari yang sudah Anda miliki.'
            );
        }

        // Logika Upgrade
        if ($activePackage) {
            $priceDifference = $newPackage->price - $activePackage->price;

            if ($priceDifference <= 0) {
                return redirect()->route('premium.index')->with('error', 'Paket ini tidak bisa diupgrade karena memiliki harga lebih rendah atau sama.');
            }

            if ($user->saldo < $priceDifference) {
                return redirect()->route('premium.index')->with('error', 'Saldo Anda tidak cukup untuk upgrade paket.');
            }

            // Kurangi saldo user
            $user->decrement('saldo', $priceDifference);

            // Update pivot table untuk paket baru
            $user->premiumPackages()->attach($newPackage->id, [
                'premium_expires_at' => now()->addMonth(), // Tambahkan masa berlaku baru
            ]);

            // Hapus paket aktif sebelumnya
            $user->premiumPackages()->detach($activePackage->id);

            // Tambahkan Premium Badge jika Paket 3
            if ($newPackage->id === 3) {
                $user->update([
                    'premium_badge' => 'Premium Badge',
                ]);
            }

            return redirect()->route('premium.index')->with('success', 'Paket Anda berhasil diupgrade.');
        }

        // Logika Pembelian Baru
        if ($user->saldo < $newPackage->price) {
            return redirect()->route('premium.index')->with('error', 'Saldo Anda tidak cukup.');
        }

        $user->decrement('saldo', $newPackage->price);

        // Tambahkan paket ke pivot table
        $user->premiumPackages()->attach($newPackage->id, [
            'premium_expires_at' => now()->addMonth(),
        ]);

        // Tambahkan Premium Badge jika Paket 3
        if ($newPackage->id === 3) {
            $user->update([
                'premium_badge' => 'Premium Badge',
            ]);
        }

        return redirect()->route('premium.index')->with('success', 'Pembelian paket premium berhasil.');
    }

}
