<?php

// database/seeders/CategorySeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            ['category_name' => 'Makanan Pembuka'],
            ['category_name' => 'Makanan Utama'],
            ['category_name' => 'Makanan Penutup'],
            ['category_name' => 'Minuman'],
            ['category_name' => 'Cemilan'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}

