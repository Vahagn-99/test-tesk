<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i < 15; $i++) {
            Product::create([
                'article' => 'example-' . $i,
                'name' => 'example-' . $i,
                'status' => rand(0, 1),
                'data' => json_encode([
                    'key  ' . $i => 'data example ' . $i,
                    'key  ' . $i => 'data example ' . $i,
                    'key  ' . $i => 'data example ' . $i,
                ])
            ]);
        }
    }
}
