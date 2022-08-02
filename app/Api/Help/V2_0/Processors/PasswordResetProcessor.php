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
class PasswordResetProcessor extends AbstractProcessor
{
	protected function rules(Binder $binder)
	{
		$binder->bind('username', function(Property $property){
			$property->addRule(new Obligate())->addRule(new StringCast());
		});
	}

	protected function allowable()
	{
		return ['username'];
	}

	/**
	 * @return string
	 */
	public function getUsername()
	{
		return $this->get('username');
	}
}