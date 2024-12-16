<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Voucher;
use App\Models\Menu;
use Illuminate\Http\Request;

class VoucherController extends Controller
{
    public function addVouchers(Request $request)
    {
        $request->validate([
            'voucher_code' => 'required|unique:vouchers,voucher_code|max:255',
            'discount' => 'required|numeric|min:1|max:100',
            'expiry_date' => 'required|date|after:today',
            'type' => 'required|in:general,specific',
            'menu_id' => 'nullable|exists:menus,id',
        ]);

        Voucher::create([
            'voucher_code' => $request->voucher_code,
            'discount' => $request->discount,
            'expiry_date' => $request->expiry_date,
            'type' => $request->type,
            'menu_id' => $request->type === 'specific' ? $request->menu_id : null,
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Voucher berhasil dibuat.');
    }

    public function removeVoucher($id)
    {
        $voucher = Voucher::findOrFail($id);
        $voucher->delete();

        return view('admin.dashboard')->with('success', 'Voucher berhasil dihapus.');
    }
}

