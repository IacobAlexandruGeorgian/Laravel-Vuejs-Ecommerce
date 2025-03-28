<?php

namespace Database\Seeders;

use App\Models\Order;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $orders = DB::connection('old_mysql')->table('orders')->get();

        foreach ($orders as $order) {
            Order::create([
                'id' => $order->id,
                'code' => $order->code,
                'user_id' => $order->user_id,
                'created_at' => $order->created_at,
                'updated_at' => $order->updated_at
            ]);
        }
    }
}
