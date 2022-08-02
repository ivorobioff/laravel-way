<?php
namespace RealEstate\Core\Document\Exceptions;

use Restate\Libraries\Validation\PresentableException;
use RealEstate\Core\Document\Enums\Format;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class InvalidFormatException extends PresentableException
{
	public function __construct()
	{
		parent::__construct('The document must be in one of the following formats: '.implode(', ', Format::toArray()));
	}
}