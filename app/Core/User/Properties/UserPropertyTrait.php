<?php
namespace RealEstate\Core\User\Properties;

use RealEstate\Core\User\Entities\User;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
trait UserPropertyTrait
{
	/**
	 * @var User
	 */
	private $user;

	/**
	 * @param User $user
	 */
	public function setUser(User $user)
	{
		$this->user = $user;
	}

	/**
	 * @return User
	 */
	public function getUser()
	{
		return $this->user;
	}
}