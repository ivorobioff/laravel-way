<?php
namespace RealEstate\Core\Customer\Validation;

use Restate\Libraries\Validation\Binder;
use Restate\Libraries\Validation\Property;
use Restate\Libraries\Validation\Rules\Blank;
use Restate\Libraries\Validation\Rules\Obligate;
use RealEstate\Core\Appraisal\Validation\MessageValidator as BaseMessageValidator;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class MessageValidator extends BaseMessageValidator
{
	/**
	 * @param Binder $binder
	 * @return void
	 */
	protected function define(Binder $binder)
	{
		parent::define($binder);

		$binder->bind('employee', function(Property $property){
			$property
				->addRule(new Obligate())
				->addRule(new Blank());
		});
	}
}