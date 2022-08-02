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
class HelpProcessor extends AbstractProcessor
{
	protected function rules(Binder $binder)
	{
		$binder->bind('description', function(Property $property){
			$property
				->addRule(new StringCast())
				->addRule(new Obligate());
		});
	}

	/**
	 * @return string
	 */
	public function getDescription()
	{
		return $this->get('description');
	}
}