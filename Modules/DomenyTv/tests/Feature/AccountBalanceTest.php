<?php

namespace Modules\DomenyTv\tests\Feature;

use SoapClient;
use Tests\TestCase;

class AccountBalanceTest extends TestCase
{
    const FILE_XML = 'soap.wdl.xml';

    /**
     * A basic feature test example.
     */
    public function testExample(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function testCheckDomenyTv(): void
    {
        $response = $this->get(route('api.domenytv'));

        $response->assertStatus(200);
    }

    public function testReadSoapWdlXmlFile()
    {
        $client = $this->connectWithServerWdl();

        $this->assertCount(52, $client->__getFunctions());
    }

    public function testCheckIsAccountBalanceFunctionIsInSoapWdlXmlFile()
    {
        $client = $this->connectWithServerWdl();

        $commandExists = false;
        foreach ($client->__getFunctions() as $function) {
            if (str_contains($function, 'accountBalance')) {
                $commandExists = true;

                break;
            }
        }

        $this->assertTrue($commandExists);
    }

    /**
     * @throws \SoapFault
     */
    private function connectWithServerWdl(): SoapClient
    {
        return new SoapClient(route('api.domenytv') . '/' . self::FILE_XML, $this->optionToConnectWdl());
    }

    private function optionToConnectWdl()
    {
        return [
            'stream_context' => stream_context_create([
                'ssl' => [
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true,
                ],
            ]),
            'cache_wsdl' => WSDL_CACHE_NONE,
        ];
    }
}
