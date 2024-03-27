<?php

namespace Modules\DomenyTv\App\Http\Controllers;

use SoapFault;

class SoapHandler
{
    public function handleRequest($methodName, $parameters) {
        if (method_exists($this, $methodName)) {
            return $this->$methodName($parameters);
        } else {
            throw new SoapFault("Server", "Method not found: $methodName");
        }
    }
    public function accountBalance($parameters)
    {
        if ($parameters->login !== 'good_login' && $parameters->password !== 'good_password') {
            return ['result' => 27];
        }

        return ['result' => 1000, 'balance' => (string) 3210.66]; // Let us assume that the balance is 3210.66
    }

    public function checkDomainExtended($parameters)
    {
        if ($parameters->login !== 'good_login' && $parameters->password !== 'good_password') {
            return ['result' => 27];
        }

        if (! isset($parameters->domain)) {
            return ['result' => 16];
        }

        if (empty($parameters->domain)) {
            return ['result' => 1];
        }

        return ['result' => 1000, 'balance' => (string) 3210.66]; // Let us assume that the balance is 3210.66
    }

    public function checkDomainDns($parameters)
    {
        return ['result' => 1000, [
            'dns1' => 'dns.' . ($parameters->domain ?: 'olsza.info'),
            'dns2' => 'dns2.' . ($parameters->domain ?: 'czlowiek.it'),
            'dns3' => 'dns3.' . ($parameters->domain ?: 'domeny.tv'),
        ]];
    }
}
