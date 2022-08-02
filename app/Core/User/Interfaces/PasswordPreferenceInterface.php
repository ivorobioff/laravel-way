<?php
namespace RealEstate\Core\User\Interfaces;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
interface PasswordPreferenceInterface
{
	/**
	 * @return int
	 */
	public function getResetTokenLifetime();
}