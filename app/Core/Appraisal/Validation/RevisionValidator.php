<?php
namespace RealEstate\Core\Appraisal\Validation;

use Restate\Libraries\Validation\AbstractThrowableValidator;
use Restate\Libraries\Validation\Binder;
use Restate\Libraries\Validation\Property;
use Restate\Libraries\Validation\Rules\Obligate;
use Restate\Libraries\Validation\SourceHandlerInterface;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class RevisionValidator extends AbstractThrowableValidator
{
	/**
	 * @param Binder $binder
	 * @return void
	 */
	protected function define(Binder $binder)
	{
		$binder->bind('message', function(Property $property){
			$property->addRule(new Obligate());
		})->when(function(SourceHandlerInterface $source){
			return $source->getValue('checklist') === null;
		});
	}
}