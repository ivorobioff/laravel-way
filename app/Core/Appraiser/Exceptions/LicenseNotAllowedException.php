<?php
namespace RealEstate\Core\Appraiser\Exceptions;

use Restate\Libraries\Validation\PresentableException;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class LicenseNotAllowedException extends PresentableException
{
	public function __construct()
	{
		parent::__construct('The provided license does not belong to the provided appraiser.');
	}
}