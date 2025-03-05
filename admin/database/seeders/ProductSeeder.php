<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = DB::connection('old_mysql')->table('products')->get();

        foreach ($products as $product) {
            Product::create([
                'id' => $product->id,
                'title' => $product->title,
                'description' => $product->description,
                'image' => $product->image,
                'price' => $product->price
            ]);
        }
    }
}
