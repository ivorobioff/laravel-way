<?php
namespace RealEstate\Api\Customer\V2_0\Processors;

use Restate\Libraries\Processor\AbstractProcessor;
use Restate\Libraries\Validation\Binder;
use Restate\Libraries\Validation\Property;
use Restate\Libraries\Validation\Rules\Blank;
use Restate\Libraries\Validation\Rules\Length;
use Restate\Libraries\Validation\Rules\Obligate;
use Restate\Libraries\Validation\Rules\StringCast;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class AdditionalDocumentTypesProcessor extends AbstractProcessor
{
	protected function rules(Binder $binder)
	{
		$binder->bind('title', function(Property $property){
			$property
				->addRule(new Obligate())
				->addRule(new StringCast())
				->addRule(new Blank())
				->addRule(new Length(1, 255));
		});
	}

	/**
	 * @return string
	 */
	public function getTitle()
	{
		return $this->get('title');
	}
}