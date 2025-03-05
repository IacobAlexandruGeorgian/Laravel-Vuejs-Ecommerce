<?php

namespace App\Console\Commands;

use App\Models\Order;
use App\Services\UserService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;

class UpdateRankingsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:rankings';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $userService = new UserService();

        $users = collect($userService->all(-1));

        $users = $users->filter(function ($user) {
            return $user->is_influencer;
        });

        $users->each(function ($user) {
            $orders = Order::where('user_id', $user->id)->get();
            $revenue = $orders->sum(function (Order $order) {
                return (int)$order->influencer_total;
            });

            Redis::zadd('rankings', $revenue, $user->first_name . ' ' . $user->last_name);
        });
    }
}
