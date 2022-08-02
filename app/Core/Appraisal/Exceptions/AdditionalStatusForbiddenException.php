<?php
namespace RealEstate\Core\Appraisal\Exceptions;

use Restate\Libraries\Validation\PresentableException;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class AdditionalStatusForbiddenException extends PresentableException
{
	public function __construct()
	{
		parent::__construct('The provided additional status does not belong to the provided customer.');
	}
}