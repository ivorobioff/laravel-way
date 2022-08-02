<?php
namespace RealEstate\Api\Assignee\V2_0\Processors;

use Restate\Libraries\Processor\AbstractProcessor;
use Restate\Libraries\Validation\Binder;
use Restate\Libraries\Validation\Property;
use Restate\Libraries\Validation\Rules\Enum;
use Restate\Libraries\Validation\Rules\Obligate;
use Restate\Libraries\Validation\Rules\StringCast;
use RealEstate\Core\Appraisal\Enums\DeclineReason;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class OrderDeclineProcessor extends AbstractProcessor
{
	/**
	 * @param Binder $binder
	 */
	protected function rules(Binder $binder)
	{
		$binder->bind('reason', function(Property $property){
			$property
				->addRule(new Obligate())
				->addRule(new Enum(DeclineReason::class));
		});

		$binder->bind('message', function(Property $property){
			$property
				->addRule(new StringCast());
		});
	}

	protected function allowable()
	{
		return [
			'reason', 'message'
		];
	}

	/**
	 * @return DeclineReason
	 */
	public function getDeclineReason()
	{
		return new DeclineReason($this->get('reason'));
	}

	/**
	 * @return string
	 */
	public function getDeclineMessage()
	{
		return $this->get('message');
	}
}