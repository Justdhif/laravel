<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PremiumPackage;

class PremiumPackageSeeder extends Seeder
{
    public function run()
    {
        PremiumPackage::create([
            'name' => 'Paket 1',
            'description' => 'Diskon acak pada beberapa menu.',
            'price' => 100000,
            'features' => ['Diskon acak pada beberapa menu'],
            'level' => 1, // Tambahkan level
        ]);

        PremiumPackage::create([
            'name' => 'Paket 2',
            'description' => 'Diskon tetap pada semua menu.',
            'price' => 200000,
            'features' => ['Diskon 20% pada semua menu'],
            'level' => 2, // Tambahkan level
        ]);

        PremiumPackage::create([
            'name' => 'Paket 3',
            'description' => 'Diskon tetap pada semua menu dan badge premium.',
            'price' => 300000,
            'features' => ['Diskon 20% pada semua menu', 'Premium Badge'],
            'level' => 3, // Tambahkan level
        ]);
    }
}
