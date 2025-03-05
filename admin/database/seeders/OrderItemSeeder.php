<?php

namespace Database\Seeders;

use App\Models\OrderItem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $orderItems = DB::connection('old_mysql')->table('order_items')->get();

        foreach ($orderItems as $orderItem) {
            OrderItem::create([
                'id' => $orderItem->id,
                'title' => $orderItem->title,
                'description' => $orderItem->description,
                'image' => $orderItem->image,
                'price' => $orderItem->price
            ]);
        }
    }
}
