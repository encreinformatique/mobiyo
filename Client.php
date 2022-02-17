<?php
/**
 * @package EncreInformatique\Mobiyo
 * User: jdevergnies
 * Date: 09/11/2018
 * Time: 09:25
 */

namespace EncreInformatique\Mobiyo;

class Client
{
    const URL_WSDL = 'https://wshiconnect.mediakiosque.com/ws/wsdl/Hiconnect.wsdl';

    /**
     * @var string
     */
    protected $login;

    /**
     * @var string
     */
    protected $password;

    /**
     * @var \SoapClient $soapClient
     */
    protected $soapClient;

    /**
     * Client constructor.
     * @param string $login
     * @param string $password
     */
    public function __construct(string $login, string $password)
    {
        $options = [
            'login' => $login,
            'password' => $password,
            'wsdl_cache' => 0,
            'trace' => 1
        ];

        $this->login = $login;
        $this->password = $password;
        $this->soapClient = new \SoapClient(self::URL_WSDL, $options);
    }

    /**
     * @param Payload $payload
     * @return Response
     * @throws \RuntimeException
     */
    public function getNumber(Payload $payload)
    {
        $arguments = $this->prepareArguments($payload);

        try {
            $response = $this->soapClient->__soapCall('reserver_numero', $arguments);
        } catch (\SoapFault $exception) {
            throw new \RuntimeException(sprintf('Soap error : %s', $exception->getMessage()));
        }

        $transformedNumber = '';
        $idReservation = null;
        $statusCode = Response::CODE_UNKNOWN;
        $statusMessage = null;
        if (\is_array($response) && \isset($response['errcode'])) {
            switch ($response['errcode']) {
                case 'OK':
                    $transformedNumber = $response['numero_reserve'];
                    $idReservation = $response['id_resa'];
                    $statusCode = Response::CODE_SUCCESS;
                    $statusMessage = 200;
                    break;
                default:
                    $statusCode = $response['errno'];
                    $statusMessage = $response['errmessage'];
                    break;
            }
        }

        return new Response($transformedNumber, $idReservation, $statusCode, $statusMessage);
    }

    /**
     * @param Payload $payload
     * @return array
     */
    protected function prepareArguments(Payload $payload): array
    {
        $arguments = array(
            'destination' => $payload->getPlainPhone(),
            'duree_resa' => $payload->getLength(),
            'customer' => $payload->getCustomer(),
            'ip' => $payload->getCallerIp(),
            'nom_cab' => $payload->getCabinet(),
            'site' => $payload->getWebsite()
        );
        return $arguments;
    }
}
