<?php
namespace RealEstate\Api\Appraisal\V2_0\Processors;

use Restate\Libraries\Processor\AbstractProcessor;
use Restate\Libraries\Validation\Binder;
use Restate\Libraries\Validation\Property;
use Restate\Libraries\Validation\Rules\IntegerCast;
use Restate\Libraries\Validation\Rules\Obligate;
use Restate\Libraries\Validation\Rules\StringCast;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class ChangeAdditionalStatusProcessor extends AbstractProcessor
{
	protected function rules(Binder $binder)
	{
		$binder->bind('additionalStatus', function(Property $property){
			$property
				->addRule(new Obligate())
				->addRule(new IntegerCast());
		});

		$binder->bind('comment', function(Property $property){
			$property
				->addRule(new StringCast());
		});
	}

	/**
	 * @return int
	 */
	public function getAdditionalStatus()
	{
		return (int) $this->get('additionalStatus');
	}

	/**
	 * @return string
	 */
	public function getComment()
	{
		return $this->get('comment');
	}
}