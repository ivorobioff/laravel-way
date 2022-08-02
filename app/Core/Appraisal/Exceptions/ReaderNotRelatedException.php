<?php
namespace RealEstate\Core\Appraisal\Exceptions;

use Restate\Libraries\Validation\PresentableException;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class ReaderNotRelatedException extends PresentableException
{
	public function __construct()
	{
		parent::__construct('The provided user is not related to one (or more) of the provided messages.');
	}
}