<?php
namespace RealEstate\Live\Handlers;

use Restate\Libraries\Transformer\SharedModifiers;
use RealEstate\Api\Appraisal\V2_0\Transformers\OrderTransformer;
use RealEstate\Core\Appraisal\Enums\ProcessStatus;
use RealEstate\Core\Appraisal\Notifications\UpdateProcessStatusNotification;
use RealEstate\Core\Appraisal\Notifications\UpdateProcessStatusNotificationAwareInterface;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class UpdateProcessStatusHandler extends AbstractOrderHandler
{
	/**
	 * @return string
	 */
	protected function getName()
	{
		return 'update-process-status';
	}

	/**
	 * @param UpdateProcessStatusNotification|UpdateProcessStatusNotificationAwareInterface $notification
	 * @return array
	 */
	protected function getData($notification)
	{
		if ($notification instanceof UpdateProcessStatusNotificationAwareInterface){
			$notification = $notification->getUpdateProcessStatusNotification();
		}

		$data = [
			'order' => $this->transformer(OrderTransformer::class)->transform($notification->getOrder()),
			'oldProcessStatus' => (string) $notification->getOldProcessStatus(),
			'newProcessStatus' => (string) $notification->getNewProcessStatus()
		];

		if ($notification->getNewProcessStatus()->is(ProcessStatus::ON_HOLD)){
			$data['explanation'] = $notification->getOrder()->getComment();
		}

		if ($notification->getNewProcessStatus()->is(ProcessStatus::INSPECTION_COMPLETED)){
			$modifier = new SharedModifiers();

			$data['completedAt'] = $modifier->datetime(
				$notification->getExtra()[UpdateProcessStatusNotification::EXTRA_COMPLETED_AT]);

			$data['estimatedCompletionDate'] = $modifier->datetime(
				$notification->getExtra()[UpdateProcessStatusNotification::EXTRA_ESTIMATED_COMPLETION_DATE]);
		}

		if ($notification->getNewProcessStatus()->is(ProcessStatus::INSPECTION_SCHEDULED)){
			$modifier = new SharedModifiers();

			$data['scheduledAt'] = $modifier->datetime(
				$notification->getExtra()[UpdateProcessStatusNotification::EXTRA_SCHEDULED_AT]);

			$data['estimatedCompletionDate'] = $modifier->datetime(
				$notification->getExtra()[UpdateProcessStatusNotification::EXTRA_ESTIMATED_COMPLETION_DATE]);
		}

		return $data;
	}
}