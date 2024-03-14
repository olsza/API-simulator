<?php

namespace Modules\DomenyTv\tests\Feature;

use SoapClient;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

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
        $client = $this->conectWithServerWdl();

        $this->assertCount(52, $client->__getFunctions());
    }

    private function conectWithServerWdl(): SoapClient
    {
        return new SoapClient(route('api.domenytv') . "/" . self::FILE_XML, $this->optionToConectWdl());
    }

    private function optionToConectWdl()
    {
        return [
            'stream_context' => stream_context_create([
                'ssl' => [
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                ]
            ])
        ];
    }
}
