<?php

namespace Modules\DomenyTv\App\Http\Controllers;

class SoapHandler
{
    public function accountBalance($login, $password)
    {
        if ($login !== 'good_login' && $password !== 'good_password') {
            return ['result' => 27];
        }

        return ['result' => 1000, 'balance' => (string) 3210.66]; // Let us assume that the balance is 3210.66
    }

    public function checkDomainDns($login, $password, $domain = null)
    {
        return ['result' => 1000, [
            'dns1' => 'dns.' . ($domain ?: 'olsza.info'),
            'dns2' => 'dns2.' . ($domain ?: 'czlowiek.it'),
            'dns3' => 'dns3.' . ($domain ?: 'domeny.tv'),
        ]];
    }
}
