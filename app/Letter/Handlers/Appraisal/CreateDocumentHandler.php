<?php
namespace RealEstate\Letter\Handlers\Appraisal;

use RealEstate\Core\Appraisal\Notifications\AbstractNotification;
use RealEstate\Core\Appraisal\Notifications\CreateDocumentNotification;
use RealEstate\Core\Document\Interfaces\DocumentPreferenceInterface;
use RealEstate\Support\Shortcut;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class CreateDocumentHandler extends AbstractOrderHandler
{
	/**
	 * @param AbstractNotification|CreateDocumentNotification $notification
	 * @return string
	 */
	protected function getSubject(AbstractNotification $notification)
	{
		return 'New Document - Order on '.$notification->getOrder()->getProperty()->getDisplayAddress();
	}

	/**
	 * @param AbstractNotification|CreateDocumentNotification $notification
	 * @return array
	 */
	protected function getData(AbstractNotification $notification)
	{
		$data = parent::getData($notification);

		$data['document'] = $notification->getDocument()->getPrimary()->getName();

		return $data;
	}

	/**
	 * @param AbstractNotification|CreateDocumentNotification $notification
	 * @return string
	 */
	protected function getActionUrl(AbstractNotification $notification)
	{
		/**
		 * @var DocumentPreferenceInterface $preference
		 */
		$preference = $this->container->make(DocumentPreferenceInterface::class);

		return Shortcut::extractUrlFromDocument($notification->getDocument()->getPrimary(), $preference);
	}

	/**
	 * @return string
	 */
	protected function getTemplate()
	{
		return 'emails.appraisal.create_document';
	}
}