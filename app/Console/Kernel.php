<?php

namespace App\Console;

use App\Models\Setting;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $setting = Setting::select('id', 'ig_username', 'ig_password', 'isIntegrated')->first();
        if (!empty($setting)) {
            $schedule->exec('python3.9 /var/www/compro_hero57/hero-57/public/cron/insta.py', [$setting->ig_username, $setting->ig_password])
                ->timezone('Asia/Jakarta')
                ->cron('* * * * *')
                ->sendOutputTo('/var/www/compro_hero57/hero-57/public/cron/error-hero.txt');
        } else {
            dd("Setting integration Not Found");
        }
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
