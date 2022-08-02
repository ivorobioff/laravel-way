<?php
namespace RealEstate\Core\Appraiser\Validation;

use Restate\Libraries\Validation\AbstractThrowableValidator;
use Restate\Libraries\Validation\Binder;
use RealEstate\Core\Appraiser\Validation\Definers\AchDefiner;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class AchValidator extends AbstractThrowableValidator
{
	/**
	 * @param Binder $binder
	 * @return void
	 */
	protected function define(Binder $binder)
	{
        $definer = new AchDefiner();
        $definer->define($binder);
	}
}