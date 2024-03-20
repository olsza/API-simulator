<?php

namespace Modules\DomenyTv\App\Http\Controllers;

use Illuminate\Routing\Controller;

class SoapHandlerController extends Controller
{
    public function __call(mixed $method, mixed $arguments): array|string
    {
        $className = ucfirst($method) . 'CommandHandler';
        dd($className,$method,$arguments);
        if (class_exists('Modules\DomenyTv\App\Http\Controllers\\' . $className)) {
            $handler = new $className();
            if (count($arguments) < 2 || ! isset($arguments[0]) || ! isset($arguments[1])) {
                return $this->soapFault("Error cannot find parameter");
            }
            if ($handler->authenticate($arguments[0], $arguments[1])) {
                return $handler->handle(...array_slice($arguments, 0, 2));
            } else {
                return ['result' => 27]; // Returns error code 27 on failed login
            }
        } else {
            return $this->soapFault("Invalid method: $method");
        }
    }

    /**
     * Helper function for generating SOAP error XML
     **/
    private function soapFault($message): string
    {
        $xml = '<?xml version="1.0" encoding="UTF-8"?>
<SOAP-ENV:Envelope
	xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/">
	<SOAP-ENV:Body>
		<SOAP-ENV:Fault>
			<faultcode>SOAP-ENV:Client</faultcode>
			<faultstring>' . $message . '</faultstring>
		</SOAP-ENV:Fault>
	</SOAP-ENV:Body>
</SOAP-ENV:Envelope>';

        return $xml;
    }

//    public function accountBalance($login, $password): array
//    {
//        return ['result' => 3210]; // Let us assume that the balance is 3210
//    }
//
//    public function checkDomainExtended($login, $password, $domain = null): string
//    {
//        if ($domain) {
//            return "Extended information about domain $domain";
//        } else {
//            return "Please provide a domain to check";
//        }
//    }
}
