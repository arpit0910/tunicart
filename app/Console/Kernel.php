<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Bootstrap the application's console services.
     *
     * @return void
     */
    public function bootstrap()
    {
        parent::bootstrap();

        $oldHandler = set_error_handler(function ($level, $message, $file = '', $line = 0, $context = []) use (&$oldHandler) {
            if ($level === E_DEPRECATED || $level === E_USER_DEPRECATED) {
                return true;
            }
            if ($oldHandler) {
                return call_user_func($oldHandler, $level, $message, $file, $line, $context);
            }
            return false;
        });
    }

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
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
