<?php
namespace RealEstate\Push\Handlers\Customer\Appraisal;

use Restate\Libraries\Transformer\SharedModifiers;
use RealEstate\Core\Appraisal\Enums\ProcessStatus;
use RealEstate\Core\Appraisal\Notifications\UpdateProcessStatusNotification;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class UpdateProcessStatusHandler extends BaseHandler
{
	/**
	 * @param UpdateProcessStatusNotification $notification
	 * @return array
	 */
	protected function transform($notification)
	{
		$data = [
			'type' => 'order',
			'event' => 'update-process-status',
			'order' => $notification->getOrder()->getId(),
			'oldProcessStatus' => (string) $notification->getOldProcessStatus(),
			'newProcessStatus' => (string) $notification->getNewProcessStatus()
		];

		if ($notification->getNewProcessStatus()->is(ProcessStatus::INSPECTION_SCHEDULED)){
			$modifier = new SharedModifiers();

			$data['scheduledAt'] = $modifier->datetime(
				$notification->getExtra()[UpdateProcessStatusNotification::EXTRA_SCHEDULED_AT]);

			$data['estimatedCompletionDate'] = $modifier->datetime(
				$notification->getExtra()[UpdateProcessStatusNotification::EXTRA_ESTIMATED_COMPLETION_DATE]);
		}

		if ($notification->getNewProcessStatus()->is(ProcessStatus::INSPECTION_COMPLETED)){
			$modifier = new SharedModifiers();

			$data['completedAt'] = $modifier->datetime(
				$notification->getExtra()[UpdateProcessStatusNotification::EXTRA_COMPLETED_AT]);

			$data['estimatedCompletionDate'] = $modifier->datetime(
				$notification->getExtra()[UpdateProcessStatusNotification::EXTRA_ESTIMATED_COMPLETION_DATE]);
		}

		return $data;
	}
}