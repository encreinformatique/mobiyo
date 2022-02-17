<?php
/**
 * @package EncreInformatique\Mobiyo
 * User: jdevergnies
 * Date: 09/11/2018
 * Time: 10:42
 */

namespace EncreInformatique\Mobiyo\Test;

use EncreInformatique\Mobiyo\Client;
use EncreInformatique\Mobiyo\Payload;
use EncreInformatique\Mobiyo\Response;
use PHPUnit\Framework\TestCase;

class ClientTest extends TestCase
{
    const LOGIN = 'testLogin';
    const PASSWORD = 'testPassword';

    /**
     * @var string
     */
    protected static $wsdlFile = 'https://wshiconnect.mediakiosque.com/ws/wsdl/Hiconnect.wsdl';

    /**
     * @test
     * @group Client
     */
    public function constructor()
    {
        $client = new Client(self::LOGIN, self::PASSWORD);

        $reflected = new \ReflectionClass($client);
        $soapClient = $reflected->getProperty('soapClient');
        $soapClient->setAccessible(true);

        $this->assertSame('EncreInformatique\Mobiyo\Client', $soapClient->class);
        $this->assertInstanceOf(\SoapClient::class, $soapClient->getValue($client));
    }

    /**
     * @test
     * @group Client
     */
    public function callingErrored()
    {
        $responseWs = [];

        $payload = new Payload('0320123456', 120);

        /*
        * This method is returning "ParseError: syntax error, unexpected '$errcode' (T_VARIABLE)"
        */
//         $soapClientMock = $this->getMockFromWsdl(self::$wsdlFile);
//         $soapClientMock
//             ->method('reserver_numero')
//             ->willReturn($responseWs);

        $client = new ClientTested(self::LOGIN, self::PASSWORD);

        $arguments = $client->prepareArguments($payload);

        $soapClientMock = $this->mockSoapClient($arguments, $responseWs);

        $client->setSoapClient($soapClientMock);
        $response = $client->getNumber($payload);

        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(Response::CODE_UNKNOWN, $response->getStatusCode());
    }

    /**
     * @test
     * @group Client
     */
    public function callingSuccessful()
    {
        $responseWs = [
            'errcode' => 'OK',
            'numero_reserve' => '0812345678',
            'id_resa' => 123
        ];
        $payload = new Payload('0320123456', 120);

        $client = new ClientTested(self::LOGIN, self::PASSWORD);

        $arguments = $client->prepareArguments($payload);

        $soapClientMock = $this->mockSoapClient($arguments, $responseWs);

        $client->setSoapClient($soapClientMock);
        $response = $client->getNumber($payload);

        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(Response::CODE_SUCCESS, $response->getStatusCode());
    }

    /**
     * @test
     * @group Client
     */
    public function mandatoryFields()
    {
        $payload = new Payload('0320123456', 120);

        $client = new ClientTested(self::LOGIN, self::PASSWORD);
        $arguments = $client->prepareArguments($payload);

        $this->assertTrue(is_array($arguments));
        $this->assertEquals($arguments['duree_resa'], 120);
        $this->assertEquals($arguments['destination'], $payload->getPlainPhone());
        $this->assertEquals($arguments['destination'], '0320123456');
    }

        /**
     * @param $arguments
     * @param $responseWs
     * @return \PHPUnit\Framework\MockObject\MockObject
     */
    private function mockSoapClient($arguments, $responseWs): \PHPUnit\Framework\MockObject\MockObject
    {
        $soapClientMock = $this->createMock(\SoapClient::class);
        $soapClientMock
            ->expects($this->once())
            ->method('__soapCall')
            ->with('reserver_numero', $arguments)
            ->willReturn($responseWs);
        return $soapClientMock;
    }

//    public static function setUpBeforeClass()
//    {
//        parent::setUpBeforeClass();
//
//        if ($content = file_get_contents(Client::URL_WSDL)) {
//            $file = __DIR__.'/mobiyo.wsdl';
//
//            file_put_contents($file, $content);
//
//            self::$wsdlFile = $file;
//        }
//    }
//
//    public static function tearDownAfterClass()
//    {
//        parent::tearDownAfterClass();
//
//        unlink(self::$wsdlFile);
//    }
}

class ClientTested extends Client
{
    public function __construct(string $login, string $password)
    {
        parent::__construct($login, $password);
    }

    public function setSoapClient(\SoapClient $soapClient)
    {
        $this->soapClient = $soapClient;
        return $this;
    }

    public function prepareArguments(Payload $payload): array
    {
        return parent::prepareArguments($payload);
    }
}
