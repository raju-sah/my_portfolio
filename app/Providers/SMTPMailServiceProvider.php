<?php

namespace App\Providers;

use App\Models\SmtpSetting;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;
class SMTPMailServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        $smtpsetting = SmtpSetting::first();

        if($smtpsetting){
            $data = [
                'driver' => $smtpsetting->mail_mailer,
                'host' => $smtpsetting->mail_host,
                'port' => $smtpsetting->mail_port,
                'encryption' => $smtpsetting->mail_encryption,
                'username' => $smtpsetting->mail_username,
                'password' => $smtpsetting->mail_password,
                'from' => [
                    'address' => $smtpsetting->mail_from_address,
                    'name' => $smtpsetting->mail_from_name,
                ]
            ];
            Config::set('mail',$data);
        }

    }
}
