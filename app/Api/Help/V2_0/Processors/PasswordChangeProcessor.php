<?php
namespace RealEstate\Api\Help\V2_0\Processors;

use Restate\Libraries\Processor\AbstractProcessor;
use Restate\Libraries\Validation\Binder;
use Restate\Libraries\Validation\Property;
use Restate\Libraries\Validation\Rules\Obligate;
use Restate\Libraries\Validation\Rules\StringCast;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class PasswordChangeProcessor extends AbstractProcessor
{
	/**
	 * @param Binder $binder
	 */
	protected function rules(Binder $binder)
	{
		$binder->bind('token', function(Property $property){
			$property->addRule(new Obligate())->addRule(new StringCast());
		});

		$binder->bind('password', function(Property $property){
			$property->addRule(new Obligate())->addRule(new StringCast());
		});
	}

	/**
	 * @return array
	 */
	protected function allowable()
	{
		return ['token', 'password'];
	}

	/**
	 * @return string
	 */
	public function getToken()
	{
		return $this->get('token');
	}

	/**
	 * @return string
	 */
	public function getPassword()
	{
		return $this->get('password');
	}
}