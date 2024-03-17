<?php

namespace Modules\DomenyTv\tests\Feature;

use Mockery;
use ReflectionClass;
use SoapClient;
use Tests\TestCase;

class AccountBalanceTest extends TestCase
{
    const FILE_XML = 'soap.wdl.xml';

    private $soapClient;

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

    public function testCheckIsAccountBalanceFunctionIsInSoapWdlXmlFile()
    {
        $client = $this->conectWithServerWdl();

        $commandExists = false;
        foreach ($client->__getFunctions() as $function) {
            if (str_contains($function, 'accountBalance')) {
                $commandExists = true;
                break;
            }
        }

        $this->assertTrue($commandExists);
    }

//    public function testSoapCommandResponseFromSpecificIP()
//    {
//        // Adres URL Twojego pliku WSDL
////        $wsdlUrl = storage_path('app/soap.wsdl.xml');
//        // Tworzenie klienta SOAP na podstawie mocka
//        $soapClient = $this->conectWithServerWdl();
//
//        // Komenda SOAP do testowania
//        $commandToTest = 'accountBalance';
//
//        // Tworzenie mocka klienta SOAP
////        $soapClientMock = $this->createMock(SoapClient::class);
//        $soapClientMock = $this->createMock(SoapClient::class);
//
//        // Oczekiwana odpowiedź z metody __soapCall
//        $expectedResponse = 'Mocked SOAP response';
//
//        // Konfiguracja mocka, aby zwracał oczekiwaną odpowiedź dla konkretnej metody i argumentów
//        $soapClientMock//->expects($this->once())
//////            ->method('__soapCall')
//        ->shouldReceive('__soapCall')
//            ->with('https://www.domeny.tv/regapi/soap.php')
////            ->with($this->equalTo($commandToTest), $this->isType('array'))
//            ->andReturn('');
//
//
//        // Zastąpienie klienta SOAP mockiem
////        $this->app->instance(SoapClient::class, $soapClientMock);
//
//        // Wywołanie komendy SOAP na serwerze
//        $response = $soapClient->__soapCall($commandToTest);
//dump('dump', $response);
//        // Sprawdzenie odpowiedzi
//        $this->assertEquals($expectedResponse, $response);
//    }

//
//    public function testSoapCommandAccountBalanceResponse()
//    {
//        $soapClient = $this->conectWithServerWdl();
//
//        // Komenda SOAP do testowania
//        $commandToTest = 'accountBalance';
//
//        $response = $soapClient->__soapCall($commandToTest, []);
//
//
//dump($response);
//
//        // Sprawdzenie odpowiedzi
//        $this->assertNotNull($response);
//        // Dodaj inne asercje, w zależności od struktury odpowiedzi SOAP
//    }

//
//    public function testSoapCommandAccountBalanceResponse()
//    {
//        // Tworzymy atrapę (mock) dla klasy SoapClient
//        $soapClientMock = $this->createMock(SoapClient::class);
//
//        // Ustawiamy oczekiwane zachowanie atrapy: zwrócenie pustej odpowiedzi i statusu 200
//        $soapClientMock->method('__soapCall')->willReturn('');
//
//        // Podmieniamy oryginalny obiekt SoapClient na atrapę w teście
//        $this->setSoapClient($soapClientMock);
//
//        // Wywołujemy testowaną metodę lub kod
//        $response = $this->callSoapCommandAccountBalance();
//
//        // Sprawdzamy, czy odpowiedź jest pusta
//        $this->assertEmpty($response);
//    }
//


//    public function setUp(): void
//    {
//        // Tworzymy atrapę (mock) dla klasy SoapClient
//        $this->soapClient = $this->createMock(SoapClient::class);
//    }

    public function testSoapCommandAccountBalanceResponse()
    {
        // Ustawiamy oczekiwane zachowanie atrapy: zwrócenie pustej odpowiedzi i statusu 200
        $this->soapClient = $this->createMock(SoapClient::class);

        $this->soapClient->expects($this->once())
            ->method('__soapCall')
            ->willReturn('');

        // Wywołujemy testowaną metodę lub kod
        $response = $this->callSoapCommandAccountBalance($this->soapClient);

        // Sprawdzamy, czy odpowiedź jest pusta
        $this->assertEmpty($response);
    }

    // Metoda, która ma być przetestowana
    public function callSoapCommandAccountBalance($soapClient)
    {
        // Tworzymy obiekt SoapClient na podstawie pliku 'katalog/soap.wdl.xml'
        $this->soapClient = $this->createMock(SoapClient::class);
        $soapClient = $this->conectWithServerWdl();

        // Komenda SOAP do testowania
        $commandToTest = 'accountBalance';

        // Wywołujemy metodę __soapCall na atrapie obiektu SoapClient
        return $soapClient->__soapCall($commandToTest, []);
    }



    /**
     * @throws \SoapFault
     */
    private function conectWithServerWdl(): SoapClient
    {
        return new SoapClient(route('api.domenytv').'/'.self::FILE_XML, $this->optionToConectWdl());
    }

    private function optionToConectWdl()
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
