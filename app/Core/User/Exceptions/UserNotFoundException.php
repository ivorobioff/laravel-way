<?php
namespace RealEstate\Core\User\Exceptions;

use Restate\Libraries\Validation\PresentableException;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class UserNotFoundException extends PresentableException
{
	public function __construct()
	{
		parent::__construct('The user has not been found with the provided details');
	}
}