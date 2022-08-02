<?php
namespace RealEstate\Core\User\Properties\Device;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
trait TokenPropertyTrait
{
	/**
	 * @var string
	 */
	private $token;

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
}