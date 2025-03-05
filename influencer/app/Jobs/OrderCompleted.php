<?php

namespace App\Jobs;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Microservices\UserService;
use Illuminate\Support\Facades\Redis;

class OrderCompleted implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $data;
    public $orderItemData;

    /**
     * Create a new job instance.
     */
    public function __construct($data, $orderItemData)
    {
        $this->data = $data;
        $this->orderItemData = $orderItemData;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $order = Order::create([
            'id' => $this->data['id'],
            'code' => $this->data['code'],
            'user_id' => $this->data['user_id'],
            'created_at' => $this->data['created_at'],
            'updated_at' => $this->data['updated_at'],
        ]);

        foreach ($this->orderItemData as $item) {
            $item['revenue'] = $item['influencer_revenue'];
            unset($item['influencer_revenue']);
            unset($item['admin_revenue']);
            OrderItem::create($item);
        }

        $revenue = $order->total;

        $userService = new UserService();

        $user = $userService->get($order->user_id);

        Redis::zincrby('rankings', $revenue, $user->fullName());
    }
}
