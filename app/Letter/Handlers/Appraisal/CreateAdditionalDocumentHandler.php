<?php
namespace RealEstate\Letter\Handlers\Appraisal;

use RealEstate\Core\Appraisal\Notifications\AbstractNotification;
use RealEstate\Core\Appraisal\Notifications\CreateAdditionalDocumentNotification;
use RealEstate\Core\Document\Interfaces\DocumentPreferenceInterface;
use RealEstate\Support\Shortcut;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class CreateAdditionalDocumentHandler extends AbstractOrderHandler
{
	/**
	 * @param AbstractNotification|CreateAdditionalDocumentNotification $notification
	 * @return string
	 */
	protected function getSubject(AbstractNotification $notification)
	{
		return 'New Additional Document - Order on '.$notification->getOrder()->getProperty()->getDisplayAddress();
	}

	/**
	 * @param AbstractNotification|CreateAdditionalDocumentNotification $notification
	 * @return array
	 */
	protected function getData(AbstractNotification $notification)
	{
		$data = parent::getData($notification);

		$data['document'] = $notification->getAdditionalDocument()->getDocument()->getName();

		return $data;
	}

	/**
	 * @param AbstractNotification|CreateAdditionalDocumentNotification $notification
	 * @return string
	 */
	protected function getActionUrl(AbstractNotification $notification)
	{
		/**
		 * @var DocumentPreferenceInterface $preference
		 */
		$preference = $this->container->make(DocumentPreferenceInterface::class);

		return Shortcut::extractUrlFromDocument($notification->getAdditionalDocument()->getDocument(), $preference);
	}

	/**
	 * @return string
	 */
	protected function getTemplate()
	{
		return 'emails.appraisal.create_additional_document';
	}
}