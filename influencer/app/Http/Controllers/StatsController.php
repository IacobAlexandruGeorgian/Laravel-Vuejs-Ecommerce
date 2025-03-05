<?php

namespace App\Http\Controllers;

use App\Models\Link;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Microservices\UserService;

class StatsController
{
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index(Request $request)
    {
        $user = $this->userService->getUser();

        $links = Link::where('user_id', $user->id)->get();

        return $links->map(function (Link $link) {
            $orders = Order::where('code', $link->code)->get();

            return [
                'code' => $link->code,
                'count' => $orders->count(),
                'revenue' => $orders->sum(function (Order $order) {
                    return (int)$order->total;
                })
            ];
        });
    }

    public function rankings()
    {
        return Redis::zrevrange('rankings', 0, -1, 'WITHSCORES');
    }
}
