<?php
namespace RealEstate\Core\Appraisal\Validation;

use Restate\Libraries\Validation\Binder;
use Restate\Libraries\Validation\Property;
use Restate\Libraries\Validation\Rules\Greater;
use Restate\Libraries\Validation\Rules\Obligate;
use Restate\Libraries\Validation\SourceHandlerInterface;
use RealEstate\Core\Appraisal\Enums\Request;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
trait ConditionsValidatorTrait
{
	/**
	 * @param Binder $binder
	 * @param array $options
	 */
	protected function defineConditions(Binder $binder, array $options = [])
	{
		if ($namespace = $path = array_take($options, 'namespace', '')){
			$namespace .= '.';
		}

		$bundle = $binder->bind($namespace.'request', function(Property $property){
			$property
				->addRule(new Obligate());
		});

		if ($path){
			$bundle->when(function(SourceHandlerInterface $source) use ($path){
				return $source->hasProperty($path);
			});
		}

		$binder->bind($namespace.'fee', function(Property $property){
			$property
				->addRule(new Greater(0));
		});

		$binder->bind($namespace.'fee', function(Property $property){
			$property
				->addRule(new Obligate());
		})->when(function(SourceHandlerInterface $source) use ($namespace){
			return $source->getValue($namespace.'request') !== null
			&& $source->getValue($namespace.'request')->is(
				[Request::FEE_INCREASE, Request::FEE_INCREASE_AND_DUE_DATE_EXTENSION]);
		});

		$binder->bind($namespace.'dueDate', function(Property $property){
			$property
				->addRule(new Obligate());
		})->when(function(SourceHandlerInterface $source) use ($namespace){
			return $source->getValue($namespace.'request') !== null
			&& $source->getValue($namespace.'request')->is(
				[Request::DUE_DATE_EXTENSION, Request::FEE_INCREASE_AND_DUE_DATE_EXTENSION]);
		});

		$bundle = $binder->bind($namespace.'explanation', function(Property $property){
			$property->addRule(new Obligate());
		});

		if ($path){
			$bundle->when(function(SourceHandlerInterface $source) use ($path){
				return $source->hasProperty($path);
			});
		}
	}
}