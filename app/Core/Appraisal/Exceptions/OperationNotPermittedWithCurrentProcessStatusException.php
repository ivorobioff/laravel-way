<?php
namespace RealEstate\Core\Appraisal\Exceptions;

use Restate\Libraries\Validation\PresentableException;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class OperationNotPermittedWithCurrentProcessStatusException extends PresentableException
{
	public function __construct()
	{
		parent::__construct('Operation is not permitted with the current process status.');
	}
}