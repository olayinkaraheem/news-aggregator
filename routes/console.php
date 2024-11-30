<?php

use Illuminate\Support\Facades\Schedule;
use App\Console\Commands\FetchNewsCommand;

Schedule::call(new FetchNewsCommand)->everyTenSeconds();
// Schedule::call(new FetchNewsCommand)->everySixHours();
