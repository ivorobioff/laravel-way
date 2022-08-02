<?php
namespace RealEstate\Core\User\Exceptions;

use Restate\Libraries\Validation\PresentableException;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class EmailNotFoundException extends PresentableException
{
	public function __construct()
	{
		parent::__construct('Unable to find email for the provided user');
	}
}