<?php
namespace RealEstate\Core\User\Emails;

use RealEstate\Core\Support\Letter\Email;
use RealEstate\Core\User\Entities\Token;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class ResetPasswordEmail extends Email
{
	/**
	 * @var Token
	 */
	private $token;

	/**
	 * @param Token $token
	 */
	public function __construct(Token $token)
	{
		$this->token = $token;
	}

	/**
	 * @return Token
	 */
	public function getToken()
	{
		return $this->token;
	}
}