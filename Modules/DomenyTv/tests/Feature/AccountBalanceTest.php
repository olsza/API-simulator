<?php

namespace Modules\DomenyTv\tests\Feature;

use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

class AccountBalanceTest extends TestCase
{
    private string $url = 'http://localhost/api/soap';

    public function test_wrong_login_and_password()
    {
        $body = $this->bodyXml('accountBalance', ['login' => 'bad_login', 'password' => 'password']);

        $response = $this->sendUrlPost($body);

        $responseBody = $response->getBody()->getContents();

        $expectedResponse = '<?xml version="1.0" encoding="UTF-8"?>
                            <SOAP-ENV:Envelope
                                xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/"
                                xmlns:ns1="urn:xmethods-delayed-quotes"
                                xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
                                xmlns:xsd="http://www.w3.org/2001/XMLSchema"
                                xmlns:ns2="http://xml.apache.org/xml-soap"
                                xmlns:SOAP-ENC="http://schemas.xmlsoap.org/soap/encoding/" SOAP-ENV:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/">
                                <SOAP-ENV:Body>
                                    <ns1:accountBalanceResponse>
                                        <return xsi:type="ns2:Map">
                                            <item>
                                                <key xsi:type="xsd:string">result</key>
                                                <value xsi:type="xsd:int">27</value>
                                            </item>
                                        </return>
                                    </ns1:accountBalanceResponse>
                                </SOAP-ENV:Body>
                            </SOAP-ENV:Envelope>';

        $this->assertXmlStringEqualsXmlString($expectedResponse, $responseBody);
    }

    public function test_good_value_balance()
    {
        $body = $this->bodyXml('accountBalance');

        $response = $this->sendUrlPost($body);

        $responseBody = $response->getBody()->getContents();

        $expectedResponse = '<?xml version="1.0" encoding="UTF-8"?>
                            <SOAP-ENV:Envelope
                                xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/"
                                xmlns:ns1="urn:xmethods-delayed-quotes"
                                xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
                                xmlns:xsd="http://www.w3.org/2001/XMLSchema"
                                xmlns:ns2="http://xml.apache.org/xml-soap"
                                xmlns:SOAP-ENC="http://schemas.xmlsoap.org/soap/encoding/" SOAP-ENV:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/">
                                <SOAP-ENV:Body>
                                    <ns1:accountBalanceResponse>
                                        <return xsi:type="ns2:Map">
                                            <item>
                                                <key xsi:type="xsd:string">result</key>
                                                <value xsi:type="xsd:int">1000</value>
                                            </item>
                                            <item>
                                                <key xsi:type="xsd:string">balance</key>
                                                <value xsi:type="xsd:string">3210.66</value>
                                            </item>
                                        </return>
                                    </ns1:accountBalanceResponse>
                                </SOAP-ENV:Body>
                            </SOAP-ENV:Envelope>';

        $this->assertXmlStringEqualsXmlString($expectedResponse, $responseBody);
    }

    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function sendUrlPost(string $body): ResponseInterface
    {
        return (new Client())->post($this->url, [
            'headers' => ['Content-Type' => 'text/xml'],
            'body' => $body,
        ]);
    }

    public function bodyXml(string $commend, ?array $parameters = []): string
    {
        if (! isset($parameters['login'])) {
            $parameters['login'] = 'good_login';
        }
        if (! isset($parameters['password'])) {
            $parameters['password'] = 'good_pass';
        }

        $xmlIn = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ser="http://localhost">
                    <soapenv:Header/>
                    <soapenv:Body>
                        <ser:' . $commend . '>
                            <input>';
        foreach ($parameters as $key => $value) {
            $xmlIn .= "\n\t\t\t\t\t<$key>$value</$key>";
        }
        $xmlIn .= '
                            </input>
                        </ser:' . $commend . '>
                    </soapenv:Body>
                </soapenv:Envelope>';

        return $xmlIn;
    }
}
