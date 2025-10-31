<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use App\Console\Commands\AICheckIn;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::call(function () {

    // The AI ​​appears every 15 minutes to post or comment.
    Schedule::command(AICheckIn::class)->everyFifteenMinutes();

});
