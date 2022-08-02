<?php
namespace RealEstate\Core\Customer\Validation;

use Restate\Libraries\Validation\AbstractThrowableValidator;
use Restate\Libraries\Validation\Binder;
use Restate\Libraries\Validation\Property;
use Restate\Libraries\Validation\Rules\Blank;
use Restate\Libraries\Validation\Rules\Greater;
use Restate\Libraries\Validation\Rules\Obligate;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class SettingsValidator extends AbstractThrowableValidator
{
	/**
	 * @param Binder $binder
	 * @return void
	 */
	protected function define(Binder $binder)
	{
		$binder->bind('pushUrl', function(Property $property){
			$property
				->addRule(new Blank());
		});

		$binder->bind('daysPriorInspectionDate', function(Property $property){
			$property
				->addRule(new Obligate())
				->addRule(new Greater(0));
		});

		$binder->bind('daysPriorEstimatedCompletionDate', function(Property $property){
			$property
				->addRule(new Obligate())
				->addRule(new Greater(0));
		});

		$binder->bind('preventViolationOfDateRestrictions', function(Property $property){
			$property
				->addRule(new Obligate());
		});

		$binder->bind('disallowChangeJobTypeFees', function(Property $property){
			$property
				->addRule(new Obligate());
		});

		$binder->bind('showClientToAppraiser', function(Property $property){
			$property
				->addRule(new Obligate());
		});

		$binder->bind('showDocumentsToAppraiser', function(Property $property){
			$property
				->addRule(new Obligate());
		});

		$binder->bind('isSmsEnabled', function(Property $property){
			$property
				->addRule(new Obligate());
		});

        $binder->bind('unacceptedReminder', function(Property $property){
            $property->addRule(new Greater(0));
        });
	}
}