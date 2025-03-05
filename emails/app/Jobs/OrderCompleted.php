<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Mail\Message;

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
        Mail::send('influencer.admin', ['id' => $this->data['id'], 'admin_total' => $this->data['admin_total']], function (Message $message) {
            $message->to('admin@admin.com');
            $message->subject('A new order has been completed!');
        });

        Mail::send('influencer.influencer', ['code' => $this->data['code'], 'influencer_total' => $this->data['influencer_total']], function (Message $message) {
            $message->to($this->data['influencer_email']);
            $message->subject('A new order has been completed!');
        });
    }
}
