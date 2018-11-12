<?php
/**
 * @package EncreInformatique\Mobiyo
 * User: jdevergnies
 * Date: 09/11/2018
 * Time: 10:02
 */

namespace EncreInformatique\Mobiyo;

class Response
{
    const CODE_SUCCESS = 200;
    const CODE_UNKNOWN = 400;

    /**
     * @var string
     */
    protected $number;
    /**
     * @var int|null
     */
    protected $idReservation;
    /**
     * @var int
     */
    protected $status;
    /**
     * @var null|string
     */
    protected $message;

    /**
     * Response constructor.
     * @param string $number
     * @param int|null $idReservation
     * @param int $status
     * @param string|null $message
     */
    public function __construct(string $number = '', int $idReservation = null, int $status = 200, string $message = null)
    {
        $this->number = $number;
        $this->idReservation = $idReservation;
        $this->status = $status;
        $this->message = $message;
    }

    /**
     * @return string
     */
    public function getNumber(): string
    {
        return $this->number;
    }

    /**
     * @return int|null
     */
    public function getIdReservation(): int
    {
        return $this->idReservation;
    }

    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->status;
    }

    /**
     * @return null|string
     */
    public function getMessage(): string
    {
        return $this->message;
    }
}
