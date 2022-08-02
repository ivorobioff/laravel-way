<?php
namespace RealEstate\Core\Payment\Objects;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class ReferencesTuple
{
	/**
	 * @var string
	 */
	private $profileId;

	/**
	 * @var string
	 */
	private $paymentProfileId;

	/**
	 * @param string $profileId
	 * @param string $paymentProfileId
	 */
	public function __construct($profileId, $paymentProfileId)
	{
		$this->profileId = $profileId;
		$this->paymentProfileId = $paymentProfileId;
	}

	/**
	 * @return string
	 */
	public function getProfileId()
	{
		return $this->profileId;
	}

	/**
	 * @return string
	 */
	public function getPaymentProfileId()
	{
		return $this->paymentProfileId;
	}
}