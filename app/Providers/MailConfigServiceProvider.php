<?php

namespace App\Providers;

use App\ConfiguracionGeneral;
use Config;
use Crypt;
use DB;
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
        $conf_mail = DB::table('configuracion_general')->first();
        if ($conf_mail) //checking if table is not empty
        {
            $config = array(
                'driver' => "smtp",
                'host' => "smtp.gmail.com",
                'port' => $conf_mail->SMTP,
                'from' => array('address' => $conf_mail->CuentaCorreo, 'name' => $conf_mail->CuentaCorreo),
                'encryption' => "tls",
                'username' => $conf_mail->CuentaCorreo,
                'password' => $conf_mail->PasswordCorreo,
            );
            Config::set('mail', $config);
        }
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
