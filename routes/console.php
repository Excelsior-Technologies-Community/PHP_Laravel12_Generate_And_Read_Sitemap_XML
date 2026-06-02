<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

// Schedule sitemap generation daily at midnight
Schedule::command('sitemap:generate')->dailyAt('00:00');

// Schedule sitemap generation every minute (for testing)
// Schedule::command('sitemap:generate')->everyMinute();

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('sitemap:list', function () {
    $this->table(
        ['Command', 'Description'],
        [
            ['sitemap:generate', 'Generate sitemap.xml file'],
            ['sitemap:ping', 'Ping search engines with sitemap URL'],
        ]
    );
})->purpose('List all sitemap commands');