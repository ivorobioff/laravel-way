<?php
namespace RealEstate\Api\Appraiser\V2_0\Processors;

use Restate\Libraries\Processor\AbstractProcessor;
use Restate\Libraries\Validation\Binder;
use Restate\Libraries\Validation\Property;
use Restate\Libraries\Validation\Rules\Obligate;
use Restate\Libraries\Validation\Rules\StringCast;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class EmailProcessor extends AbstractProcessor
{
	/**
	 * @param Binder $binder
	 */
	protected function rules(Binder $binder)
	{
		$binder->bind('email', function(Property $property){
			$property
				->addRule(new StringCast())
				->addRule(new Obligate());
		});
	}

	/**
	 * @return string
	 */
	public function getEmail()
	{
		return $this->get('email');
	}
}