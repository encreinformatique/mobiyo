<?php
/**
 * @package EncreInformatique\Mobiyo
 * User: jdevergnies
 * Date: 09/11/2018
 * Time: 09:39
 */

namespace EncreInformatique\Mobiyo;

use PHPUnit\Framework\TestCase;

class PayloadTest extends TestCase
{
    const DESTINATION = '0320123456';
    const LENGTH = '120';
    const CABINET = '';
    const CALLER_IP = '';
    const CUSTOMER = '';
    const WEBSITE = '';

    /**
     * @test
     * @group Payload
     */
    public function constructor()
    {
        $payload = new Payload(
            self::DESTINATION,
            self::LENGTH
        );

        $this->assertEquals(self::DESTINATION, $payload->getPlainPhone());
        $this->assertEquals(self::LENGTH, $payload->getLength());
    }

    /**
     * @test
     * @group Payload
     */
    public function setters()
    {
        $payload = new Payload(
            self::DESTINATION,
            self::LENGTH
        );

        $payload
            ->setWebsite(self::WEBSITE)
            ->setCabinet(self::CABINET)
            ->setCallerIp(self::CALLER_IP)
            ->setCustomer(self::CUSTOMER);

        $this->assertEquals(self::WEBSITE, $payload->getWebsite());
        $this->assertEquals(self::CABINET, $payload->getCabinet());
        $this->assertEquals(self::CALLER_IP, $payload->getCallerIp());
        $this->assertEquals(self::CUSTOMER, $payload->getCustomer());
    }
}
