<?php
namespace RealEstate\Mobile\Handlers;

use RealEstate\Api\Assignee\V2_0\Transformers\LogTransformer;
use RealEstate\Core\Log\Entities\Log;
use RealEstate\Core\Log\Enums\Action;
use RealEstate\Core\Log\Extras\Extra;
use RealEstate\Core\Log\Notifications\CreateLogNotification;
use RealEstate\Mobile\Support\HandlerInterface;
use RealEstate\Mobile\Support\News;
use RealEstate\Mobile\Support\Tuple;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class CreateLogHandler implements HandlerInterface
{
	/**
	 * @param CreateLogNotification $notification
	 * @return Tuple
	 */
	public function handle($notification)
	{
		/**
		 * It's handled by DeleteOrderHandler
		 */
		if ($notification->getLog()->getAction()->is(Action::DELETE_ORDER)){
			return null;
		}

		$news = new News();

		$log = $notification->getLog();
		$assignee = $log->getAssignee();

		if ($log->getUser()->getId() == $assignee->getId()){
			return null;
		}

		$news->setCategory('order');
		$news->setName($this->getName($log));
		$news->setExtra($this->getExtra($log));
		$news->setMessage(LogTransformer::getMessage($log));

		return new Tuple([$assignee], $news);
	}

	/**
	 * @param Log $log
	 * @return string
	 */
	private function getName(Log $log)
	{
		$action = $log->getAction();

		if ($action->is(Action::CREATE_ORDER)){
			return 'create';
		}

		if ($action->is(Action::UPDATE_ORDER)){
			return 'update';
		}

        if ($action->is(Action::AWARD_ORDER)){
            return 'award';
        }

		return $action->value();
	}

	/**
	 * @param Log $log
	 * @return array
	 */
	private function getExtra(Log $log)
	{
		$order = $log->getOrder();

		$data = [
			'order' => $order->getId()
		];

		if ($log->getAction()->is([Action::CREATE_ORDER, Action::BID_REQUEST])){
			$data['fileNumber'] = $order->getFileNumber();
			$data['processStatus'] = (string) $order->getProcessStatus();
		}

		if ($log->getAction()->is(Action::UPDATE_PROCESS_STATUS)){
			$data['fileNumber'] = $order->getFileNumber();
			$data['oldProcessStatus'] = (string) $log->getExtra()[Extra::OLD_PROCESS_STATUS];
			$data['newProcessStatus'] = (string) $log->getExtra()[Extra::NEW_PROCESS_STATUS];
		}

		return $data;
	}
}