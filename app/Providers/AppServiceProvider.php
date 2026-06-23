<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
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
}
