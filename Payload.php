<?php
/**
 * @package EncreInformatique\Mobiyo
 * User: jdevergnies
 * Date: 09/11/2018
 * Time: 09:34
 */

namespace EncreInformatique\Mobiyo;

class Payload
{
    const DEFAULT_LENGTH = 180;

    /**
     * @var string $plainPhone
     */
    protected $plainPhone;

    /**
     * Length of the reservation of number.
     *
     * @var int $length
     */
    protected $length;

    /**
     * @var string $customer
     */
    protected $customer;

    /**
     * @var string $website
     */
    protected $website;

    /**
     * Name of the pool of available numbers.
     *
     * @var string $cabinet
     */
    protected $cabinet;

    /**
     * @var string $callerIp
     */
    protected $callerIp;

    /**
     * Payload constructor.
     * @param string $plainPhone
     * @param int $length
     */
    public function __construct(string $plainPhone, int $length = self::DEFAULT_LENGTH)
    {
        $this->plainPhone = $plainPhone;
        $this->length = $length;
    }

    /**
     * @return string
     */
    public function getPlainPhone()
    {
        return $this->plainPhone;
    }

    /**
     * @return int
     */
    public function getLength()
    {
        return $this->length;
    }

    /**
     * @return string
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * @param string $customer
     * @return Payload
     */
    public function setCustomer($customer)
    {
        $this->customer = $customer;
        return $this;
    }

    /**
     * @return string
     */
    public function getWebsite()
    {
        return $this->website;
    }

    /**
     * @param string $website
     * @return Payload
     */
    public function setWebsite($website)
    {
        $this->website = $website;
        return $this;
    }

    /**
     * @return string
     */
    public function getCabinet()
    {
        return $this->cabinet;
    }

    /**
     * @param string $cabinet
     * @return Payload
     */
    public function setCabinet($cabinet)
    {
        $this->cabinet = $cabinet;
        return $this;
    }

    /**
     * @return string
     */
    public function getCallerIp()
    {
        return $this->callerIp;
    }

    /**
     * @param string $callerIp
     * @return Payload
     */
    public function setCallerIp($callerIp)
    {
        $this->callerIp = $callerIp;
        return $this;
    }
}
