<?php
namespace RealEstate\Live\Handlers;

use RealEstate\Api\Appraisal\V2_0\Transformers\MessageTransformer;
use RealEstate\Core\Appraisal\Notifications\SendMessageNotification;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class SendMessageHandler extends AbstractOrderHandler
{
	/**
	 * @return string
	 */
	protected function getName()
	{
		return 'send-message';
	}

	/**
	 * @param SendMessageNotification $notification
	 * @return array
	 */
	protected function getData($notification)
	{
		return $this->transformer(MessageTransformer::class)
			->transform($notification->getMessage());
	}
}