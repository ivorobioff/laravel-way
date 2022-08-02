<?php
namespace RealEstate\Api\Appraiser\V2_0\Controllers;

use Restate\QA\Support\Response;
use RealEstate\Api\Assignee\V2_0\Processors\SettingsProcessor;
use RealEstate\Api\Assignee\V2_0\Transformers\NotificationSubscriptionsTransformer;
use RealEstate\Api\Support\BaseController;
use RealEstate\Core\Appraiser\Services\AppraiserService;
use RealEstate\Core\Assignee\Services\NotificationSubscriptionService;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class SettingsController extends BaseController
{
	/**
	 * @var NotificationSubscriptionService
	 */
	private $notificationSubscriptionService;

	public function initialize(NotificationSubscriptionService $notificationSubscriptionService)
	{
		$this->notificationSubscriptionService = $notificationSubscriptionService;
	}

	/**
	 * @param int $appraiserId
	 * @return Response
	 */
	public function show($appraiserId)
	{
		return $this->resource->make([
			'notifications' => $this->transformer(NotificationSubscriptionsTransformer::class)
				->transform($this->notificationSubscriptionService->getAll($appraiserId))
		]);
	}

	/**
	 * @param int $appraiserId
	 * @param SettingsProcessor $processor
	 * @return Response
	 */
	public function update($appraiserId, SettingsProcessor $processor)
	{
		if ($subscriptions = $processor->createNotificationSubscriptionPersistables()){

			$this->notificationSubscriptionService
				->updateBySelectedCustomers($appraiserId, $subscriptions);
		}

		return $this->resource->blank();
	}

	/**
	 * @param AppraiserService $appraiserService
	 * @param int $appraiserId
	 * @return bool
	 */
	public static function verifyAction(AppraiserService $appraiserService, $appraiserId)
	{
		return $appraiserService->exists($appraiserId);
	}
}