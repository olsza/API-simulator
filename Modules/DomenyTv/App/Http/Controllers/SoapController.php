<?php

namespace Modules\DomenyTv\App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use SoapServer;

class SoapController extends Controller
{
    public function handle(Request $request)
    {
        $server = new SoapServer(null, ['uri' => 'urn:xmethods-delayed-quotes']);
        //        $server = new SoapServer(public_path('/modules/domenytv/soap.wsdl.xml'));

        // Define a class that supports SOAP operations
        $server->setClass(SoapHandler::class);

        // SOAP request
        ob_start();
        $server->handle($request->getContent());
        $response = ob_get_clean();

        return response($response, 200)->header('Content-Type', 'text/xml');
    }
}
