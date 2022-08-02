<?php
namespace RealEstate\Core\Payment\Validation;

use Restate\Libraries\Validation\Binder;
use Restate\Libraries\Validation\Property;
use Restate\Libraries\Validation\Rules\Blank;
use Restate\Libraries\Validation\Rules\Length;
use Restate\Libraries\Validation\Rules\Numeric;
use Restate\Libraries\Validation\Rules\Obligate;
use RealEstate\Core\Payment\Validation\Rules\CreditCardNotExpired;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class CreditCardValidator extends AbstractPaymentMethodValidator
{
	/**
	 * @param Binder $binder
	 * @return void
	 */
	protected function define(Binder $binder)
	{
        parent::define($binder);

		$binder->bind('number', function(Property $property){
			$property
				->addRule(new Obligate())
				->addRule(new Blank())
				->addRule(new Numeric())
				->addRule(new Length(13, 16));
		});

		$binder->bind('code', function(Property $property){
			$property
				->addRule(new Obligate())
				->addRule(new Blank())
				->addRule(new Numeric())
				->addRule(new Length(3, 4));
		});

		$binder->bind('expiresAt', function(Property $property){
			$property
				->addRule(new Obligate())
				->addRule(new CreditCardNotExpired());
		});
	}
}