<?php

namespace Database\Seeders;

use App\Models\LinkProduct;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LinkProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $linkProducts = DB::connection('old_mysql')->table('link_products')->get();

        foreach ($linkProducts as $linkProduct) {
            LinkProduct::create([
                'id' => $linkProduct->id,
                'link_id' => $linkProduct->code,
                'product_id' => $linkProduct->user_id
            ]);
        }
    }
}
