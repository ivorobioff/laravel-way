<?php
namespace RealEstate\Core\Appraisal\Validation;

use Restate\Libraries\Validation\AbstractThrowableValidator;
use Restate\Libraries\Validation\Binder;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class ConditionsValidator extends AbstractThrowableValidator
{
	use ConditionsValidatorTrait;

	/**
	 * @param Binder $binder
	 * @return void
	 */
	protected function define(Binder $binder)
	{
		$this->defineConditions($binder);
	}
}