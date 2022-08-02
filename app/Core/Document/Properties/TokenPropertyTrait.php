<?php
namespace RealEstate\Core\Document\Properties;

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
	 * @return string
	 */
	public function getToken()
	{
		return $this->token;
	}

	/**
	 * @param string $token
	 */
	public function setToken($token)
	{
		$this->token = $token;
	}
}