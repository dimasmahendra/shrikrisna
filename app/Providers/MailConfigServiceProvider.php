<?php

namespace App\Providers;

use Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class MailConfigServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // $config = (object) [];
        // if (\Schema::hasTable('config')) {
        //     $mail = DB::table('config')->get();
        //     foreach ($mail as $key => $val) {
        //         $config->{$val->name} = $val->nilai;
        //     }
        //     if ($config->password) //checking if table is not empty
        //     {
        //         $mailconfig = array(
        //             'driver'     => $config->driver,
        //             'host'       => $config->host,
        //             'port'       => $config->port,
        //             'username'   => $config->username,
        //             'password'   => $config->password,
        //             'encryption' => $config->encryp,
        //         );
        //         Config::set('mail', $mailconfig);
        //     }
        // }
    }
}
