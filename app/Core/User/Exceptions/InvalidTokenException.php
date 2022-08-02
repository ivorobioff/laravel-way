<?php
namespace RealEstate\Core\User\Exceptions;

use Restate\Libraries\Validation\PresentableException;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class InvalidTokenException extends PresentableException
{
	public function __construct()
	{
		parent::__construct('The token is invalid.');
	}
}