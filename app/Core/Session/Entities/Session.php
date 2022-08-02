<?php
namespace RealEstate\Core\Session\Entities;

use DateTime;
use RealEstate\Core\Shared\Properties\CreatedAtPropertyTrait;
use RealEstate\Core\Shared\Properties\IdPropertyTrait;
use RealEstate\Core\User\Properties\UserPropertyTrait;

/**
 *
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class Session
{
	use IdPropertyTrait;
	use CreatedAtPropertyTrait;
	use UserPropertyTrait;

    /**
     * @var string
     */
    private $token;

    /**
     * @var DateTime
     */
    private $expireAt;

    /**
     * @param string $token
     */
    public function setToken($token)
    {
        $this->token = $token;
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param DateTime $datetime
     */
    public function setExpireAt(DateTime $datetime)
    {
        $this->expireAt = $datetime;
    }

    /**
     * @return DateTime
     */
    public function getExpireAt()
    {
        return $this->expireAt;
    }
}