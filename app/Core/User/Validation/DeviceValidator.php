<?php
namespace RealEstate\Core\User\Validation;

use Restate\Libraries\Validation\AbstractThrowableValidator;
use Restate\Libraries\Validation\Binder;
use Restate\Libraries\Validation\Property;
use Restate\Libraries\Validation\Rules\Obligate;
use RealEstate\Core\User\Interfaces\DevicePreferenceInterface;
use RealEstate\Core\User\Validation\Rules\DeviceToken;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class DeviceValidator extends AbstractThrowableValidator
{
	/**
	 * @var DevicePreferenceInterface
	 */
	private $preference;

	/**
	 * @param DevicePreferenceInterface $preference
	 */
	public function __construct(DevicePreferenceInterface $preference)
	{
		$this->preference = $preference;
	}

	/**
	 * @param Binder $binder
	 * @return void
	 */
	protected function define(Binder $binder)
	{
		$binder->bind('token', function(Property $property){
			$property
				->addRule(new Obligate());
		});

		$binder->bind('platform', function(Property $property){
			$property->addRule(new Obligate());
		});

		$binder->bind('token', ['token', 'platform'], function(Property $property){
			$property->addRule(new DeviceToken($this->preference));
		});
	}
}