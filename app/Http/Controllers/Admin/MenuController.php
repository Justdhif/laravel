<?php

namespace App\Http\Controllers\Admin;

use App\Models\Menu;
use App\Models\Todo;
use App\Models\User;
use App\Models\Voucher;
use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\TransactionItem;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class MenuController extends Controller
{
    public function dashboardAdmin()
    {
        $admins = User::where('role', 'admin')->orderBy('created_at', 'desc')->get();
        $customers = User::where('role', 'pembeli')->orderBy('created_at', 'desc')->get();
        $menus = Menu::orderBy('created_at', 'desc')->with('category')->take(5)->get();
        $vouchers = Voucher::with('menu')->orderBy('created_at', 'desc')->get();
        $categories = Category::orderBy('created_at', 'desc')->get();
        $totalMenus = Menu::count();
        $totalVouchers = Voucher::whereDate('expiry_date', '>=', now())->count();
        $totalTransactions = Transaction::count();
        $totalStockSold = TransactionItem::sum('quantity');
        $totalSold = $menus->sum('sold');
        $topSellingMenus = Menu::orderBy('sold', 'desc')->take(5)->get();
        $transactions = Transaction::with('items')->orderBy('created_at', 'desc')->get();
        $todos = Todo::with('admin')->orderBy('created_at', 'desc')->get();

        $salesByMonth = DB::table('transactions')
        ->selectRaw('MONTH(created_at) as month, SUM(total_price) as total_sales')
        ->groupBy('month')
        ->orderBy('month')
        ->get();

        // Data bulan (1-12)
        $months = range(1, 12);

        // Buat array dengan nilai 0 untuk bulan tanpa transaksi
        $salesData = array_fill(1, 12, 0);
        foreach ($salesByMonth as $sale) {
            $salesData[$sale->month] = $sale->total_sales;
        }

        $topUser = User::where('role', 'admin') // Filter hanya pengguna dengan role admin
        ->withCount(['todos' => function ($query) {
            $query->where('status', 'completed')
                    ->whereDate('updated_at', '>=', Carbon::now()->subDays(30));
        }])
        ->orderBy('todos_count', 'desc')
        ->first();

        return view('admin.dashboard', compact('admins', 'customers', 'categories', 'transactions' ,'totalSold', 'menus', 'vouchers' ,'totalTransactions', 'totalStockSold', 'totalMenus', 'topSellingMenus' ,'totalVouchers', 'todos', 'topUser'), [
            'salesData' => array_values($salesData), // hanya nilai
            'months' => array_map(function($month) {
                return date('F', mktime(0, 0, 0, $month, 10)); // nama bulan
            }, $months),
        ]);
    }

    public function showDetailmenu($id)
    {
        $menu = Menu::with('category', 'vouchers')->findOrFail($id);
        $generalVouchers = Voucher::where('type', 'general')
        ->whereDate('expiry_date', '>=', now())
        ->get();

        return view('admin.menus.detail-menu', compact('menu','generalVouchers'));
    }

    public function showCategoriesPage()
    {
        $categories = Category::with('menus')->get();
        $menus = Menu::with('category')->get();
        return view('admin.menus.index', compact('categories'));
    }

    public function showCreateMenu()
    {
        $categories = Category::all();
        return view('admin.create-menu', compact('categories'));
    }

    public function showEditMenu($id)
    {
        $menu = Menu::findOrFail($id);
        $categories = Category::all();
        return view('admin.edit-menu', compact('menu', 'categories'));
    }

    public function addMenu(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer|min:0',
            'category_id' => 'nullable|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Mengupload gambar jika ada
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images/menus', 'public');
        }

        Menu::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'category_id' => $request->category_id,
            'image' => $imagePath,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Menu berhasil ditambahkan.');
    }

    public function updateMenu(Request $request, $id)
    {
        $menu = Menu::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer|min:0',
            'category_id' => 'nullable|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Update gambar jika ada file baru
        if ($request->hasFile('image')) {
            if ($menu->image) {
                Storage::disk('public')->delete($menu->image);
            }
            $menu->image = $request->file('image')->store('images/menus', 'public');
        }

        // Update data menu
        $menu->update([
            'name' => $request->name,
            'price' => $request->price,
            'stock' => $request->stock,
            'category_id' => $request->category_id,
            'image' => $menu->image,
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Menu berhasil di-update.');
    }

    public function destroyMenu($id)
    {
        $menu = Menu::findOrFail($id);
        $menu->delete();

        return redirect()->route('admin.dashboard')->with('success', 'Menu berhasil dihapus.');
    }
}
