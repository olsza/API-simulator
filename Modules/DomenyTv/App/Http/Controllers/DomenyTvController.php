<?php

namespace Modules\DomenyTv\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use SoapServer;

class DomenyTvController extends Controller
{
    public function handle(Request $request)
    {
        $server = new SoapServer(null, ['uri' => 'urn:xmethods-delayed-quotes']);
        //        $server = new SoapServer(public_path('/modules/domenytv/soap.wsdl.xml'));

        // Define a class that supports SOAP operations
        $server->setClass(SoapHandler::class);

        // SOAP request
        ob_start();
        $server->handle($this->parseRequest($request->getContent()));
        //        $server->handle($request->getContent());
        $response = ob_get_clean();

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
}
