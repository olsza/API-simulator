<?php

namespace Modules\DomenyTv\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use SoapServer;
use Symfony\Component\HttpFoundation\IpUtils;

class DomenyTvController extends Controller
{
    public function handle(Request $request)
    {
        $checkIp = $this->checkIp();

        if (! $checkIp) {
            $server = new SoapServer(null, ['uri' => 'urn:xmethods-delayed-quotes']);
            //        $server = new SoapServer(public_path('/modules/domenytv/soap.wsdl.xml'));

            // Define a class that supports SOAP operations
            $server->setClass(SoapHandler::class);

            // SOAP request
            ob_start();
            $server->handle($this->parseRequest($request->getContent()));
            //        $server->handle($request->getContent());
            $response = ob_get_clean();
        } else {
            $response = $checkIp;
        }

        return response($response, 200)->header('Content-Type', 'text/xml');
    }

    // A helper method to parse the request by removing the level before the element in question.
    private function parseRequest(bool | string | null $xmlRequest): string
    {
        if (strpos($xmlRequest, '<input>') !== false) {
            // If there is an XML <input> and </input> in the request then remove from the body of the request
            $xmlRequest = str_replace(['<input>', '</input>'], '', $xmlRequest);
        }

        return $xmlRequest;
    }

    private function checkIp(): false | string
    {

        $ip = request()->ip();
        if (! IpUtils::checkIp($ip, ['172.0.0.0/8', '127.0.0.1'])) {
            //            $server = new SoapServer(null, ['uri' => 'urn:xmethods-delayed-quotes']);
            $outError = '<SOAP-ENV:Envelope
	xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/">
	<SOAP-ENV:Body>
		<SOAP-ENV:Fault>
			<faultcode>69</faultcode>
			<faultstring>Unauthorized IP - ' . $ip . '</faultstring>
		</SOAP-ENV:Fault>
	</SOAP-ENV:Body>
</SOAP-ENV:Envelope>';

            return $outError;
        }

        return false;
    }
}
