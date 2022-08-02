<?php
namespace RealEstate\Push\Handlers\Customer\Appraisal;

use Restate\Libraries\Converter\Extractor\Extractor;
use Restate\Libraries\Modifier\Manager;
use Restate\Libraries\Transformer\SharedModifiers;
use RealEstate\Core\Appraisal\Notifications\AcceptOrderWithConditionsNotification;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class AcceptOrderWithConditionsHandler extends BaseHandler
{
	/**
	 * @param AcceptOrderWithConditionsNotification $notification
	 * @return array
	 */
	protected function transform($notification)
	{
		$manager = new Manager();
		$manager->registerProvider(new SharedModifiers());

		return [
			'type' => 'order',
			'event' => 'accept-with-conditions',
			'order' => $notification->getOrder()->getId(),
			'conditions' => (new Extractor())
				->setModifierManager($manager)
				->extract($notification->getConditions())
		];
	}
}