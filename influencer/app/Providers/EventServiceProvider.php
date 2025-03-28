<?php

namespace App\Providers;

use App\Jobs\LinkCreated;
use App\Jobs\OrderCompleted;
use App\Jobs\ProductCreated;
use App\Jobs\ProductDeleted;
use App\Jobs\ProductUpdated;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\App;

class EventServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        App::bindMethod(ProductCreated::class, '@handle', fn($job) => $job->handle());
        App::bindMethod(ProductUpdated::class, '@handle', fn($job) => $job->handle());
        App::bindMethod(ProductDeleted::class, '@handle', fn($job) => $job->handle());
        App::bindMethod(LinkCreated::class, '@handle', fn($job) => $job->handle());
        App::bindMethod(OrderCompleted::class, '@handle', fn($job) => $job->handle());
    }
}
