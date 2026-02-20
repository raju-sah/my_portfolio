<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // sync knowledge base every 2 days (at midnight) reason is firecrawl cache the website for 2 days since last sync
        $schedule->command('rag:sync-all')->cron('0 0 */2 * *');

        // Process queued jobs every 30 minutes
        $schedule->command('queue:work --stop-when-empty')->everyThirtyMinutes();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
