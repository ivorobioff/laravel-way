<?php
namespace RealEstate\Api\Session\V2_0\Processors;

use Restate\Libraries\Processor\AbstractProcessor;
use Restate\Libraries\Validation\Binder;
use Restate\Libraries\Validation\Property;
use Restate\Libraries\Validation\Rules\IntegerCast;
use Restate\Libraries\Validation\Rules\Obligate;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class AutoLoginTokensProcessor extends AbstractProcessor
{
	protected function rules(Binder $binder)
	{
		$binder->bind('user', function(Property $property){
			$property->addRule(new Obligate())->addRule(new IntegerCast());
		});
	}

	protected function allowable()
	{
		return ['user'];
	}

	/**
	 * @return int
	 */
	public function getUser()
	{
		return (int) $this->get('user');
	}
}