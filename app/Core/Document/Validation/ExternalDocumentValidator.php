<?php
namespace RealEstate\Core\Document\Validation;

use Restate\Libraries\Validation\AbstractThrowableValidator;
use Restate\Libraries\Validation\Binder;
use Restate\Libraries\Validation\Property;
use Restate\Libraries\Validation\Rules\Blank;
use Restate\Libraries\Validation\Rules\Greater;
use Restate\Libraries\Validation\Rules\Obligate;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class ExternalDocumentValidator extends AbstractThrowableValidator
{
	/**
	 * @param Binder $binder
	 * @return void
	 */
	protected function define(Binder $binder)
	{
		$binder->bind('name', function(Property $property){
			$property
				->addRule(new Obligate())
				->addRule(new Blank());
		});

		$binder->bind('format', function(Property $property){
			$property
				->addRule(new Obligate());
		});

		$binder->bind('size', function(Property $property){
			$property
				->addRule(new Obligate())
				->addRule(new Greater(0, false));
		});

		$binder->bind('url', function(Property $property){
			$property
				->addRule(new Obligate())
				->addRule(new Blank());
		});
	}
}