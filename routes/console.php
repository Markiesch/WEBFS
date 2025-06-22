<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Console\Scheduling\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Schedule the daily sales summary
Artisan::command('schedule:work', function (Schedule $schedule) {
    $schedule->command('app:daily-sales-summary')->daily();
});
