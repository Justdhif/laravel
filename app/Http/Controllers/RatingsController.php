<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use App\Models\Menu;
use App\Models\Ratings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RatingsController extends Controller
{
    public function addRatings(Request $request, $menuId)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'nullable|string',
            'photos.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Maks 2MB per file
        ]);

        $menu = Menu::findOrFail($menuId);

        // Simpan rating
        $rating = $menu->ratings()->create([
            'user_id' => Auth::id(),
            'rating' => $request->input('rating'),
            'review' => $request->input('review'),
        ]);

        // Simpan foto jika ada
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $path = $photo->store('reviews', 'public');
                $rating->photos()->create(['path' => $path]);
            }
        }

        return redirect()->route('menu.show', $menuId)
            ->with('success', 'Penilaian berhasil diberikan!');
    }
}
