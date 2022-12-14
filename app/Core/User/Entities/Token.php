<?php
namespace RealEstate\Core\User\Entities;

use RealEstate\Core\Shared\Properties\CreatedAtPropertyTrait;
use RealEstate\Core\Shared\Properties\IdPropertyTrait;
use RealEstate\Core\User\Enums\Intent;
use RealEstate\Core\User\Properties\UserPropertyTrait;
use DateTime;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class Token
{
	use IdPropertyTrait;
	use UserPropertyTrait;
	use CreatedAtPropertyTrait;

	/**
	 * @var string
	 */
	private $value;

	/**
	 * @var Intent
	 */
	private $intent;

	/**
	 * @var DateTime
	 */
	private $expiresAt;

	/**
	 * @return string
	 */
	public function getValue()
	{
		return $this->value;
	}

	/**
	 * @param string $value
	 */
	public function setValue($value)
	{
		$this->value = $value;
	}

	/**
	 * @return DateTime
	 */
	public function getExpiresAt()
	{
		return $this->expiresAt;
	}

	/**
	 * @param DateTime $expiresAt
	 */
	public function setExpiresAt(DateTime $expiresAt)
	{
		$this->expiresAt = $expiresAt;
	}

	/**
	 * @param Intent $intent
	 */
	public function setIntent(Intent $intent)
	{
		$this->intent = $intent;
	}

	/**
	 * @return Intent
	 */
	public function getIntent()
	{
		return $this->intent;
	}

	/**
	 * @return string
	 */
	public function __toString()
	{
		return $this->getValue();
	}
}