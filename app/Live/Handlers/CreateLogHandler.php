<?php
namespace RealEstate\Live\Handlers;

use RealEstate\Api\Assignee\V2_0\Transformers\LogTransformer;
use RealEstate\Core\Log\Notifications\CreateLogNotification;
use RealEstate\Core\User\Entities\User;
use RuntimeException;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class CreateLogHandler extends AbstractOrderHandler
{
	/**
	 * @return string
	 */
	protected function getName()
	{
		return 'create-log';
	}

	/**
	 * @param CreateLogNotification $notification
	 * @return User[]
	 */
	protected function getChannels($notification)
	{
	    if (!$notification instanceof CreateLogNotification){
            throw new RuntimeException('Unable to determine channels for the "'.get_class($notification).'" notification.');
        }

        $log = $notification->getLog();

        return $this->buildChannels($log->getAssignee(), $log->getCustomer());
	}

	/**
	 * @param CreateLogNotification $notification
	 * @return array
	 */
	protected function getData($notification)
	{
		return $this->transformer(LogTransformer::class)
			->transform($notification->getLog());
	}
}