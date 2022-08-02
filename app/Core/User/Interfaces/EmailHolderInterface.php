<?php
namespace RealEstate\Core\User\Interfaces;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
interface EmailHolderInterface
{
	/**
	 * @return string
	 */
	public function getEmail();

	/**
	 * @param string $email
	 */
	public function setEmail($email);
}