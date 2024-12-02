<?php

use App\Jobs\FetchNewsJob;
use Illuminate\Support\Facades\Queue;

test('Command app:fetch-news exited successfully', function () {
    Queue::fake();

    $this->artisan('app:fetch-news')->assertExitCode(0);

    Queue::assertPushed(FetchNewsJob::class);
})->group('console');
