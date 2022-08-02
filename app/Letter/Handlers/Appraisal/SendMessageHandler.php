<?php
namespace RealEstate\Letter\Handlers\Appraisal;

use RealEstate\Core\Appraisal\Notifications\AbstractNotification;
use RealEstate\Core\Appraisal\Notifications\SendMessageNotification;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class SendMessageHandler extends AbstractOrderHandler
{
	/**
	 * @param AbstractNotification|SendMessageNotification $notification
	 * @return string
	 */
	protected function getSubject(AbstractNotification $notification)
	{
		return 'Message - Order on '.$notification->getOrder()->getProperty()->getDisplayAddress();
	}

	/**
	 * @return string
	 */
	protected function getTemplate()
	{
		return 'emails.appraisal.send_message';
	}

	/**
	 * @param AbstractNotification|SendMessageNotification $notification
	 * @return array
	 */
	protected function getData(AbstractNotification $notification)
	{
		$data = parent::getData($notification);

		$data['content'] = $notification->getMessage()->getContent();

		return $data;
	}

	/**
	 * @param AbstractNotification|SendMessageNotification $notification
	 * @return string
	 */
	protected function getActionUrl(AbstractNotification $notification)
	{
		return $this->config->get('app.front_end_url').'/orders/details/'.$notification->getOrder()->getId().'/messages';
	}
}