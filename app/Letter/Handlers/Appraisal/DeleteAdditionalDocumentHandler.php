<?php
namespace RealEstate\Letter\Handlers\Appraisal;

use RealEstate\Core\Appraisal\Notifications\AbstractNotification;
use RealEstate\Core\Appraisal\Notifications\DeleteAdditionalDocumentNotification;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class DeleteAdditionalDocumentHandler extends AbstractOrderHandler
{
	/**
	 * @param AbstractNotification|DeleteAdditionalDocumentNotification $notification
	 * @return string
	 */
	protected function getSubject(AbstractNotification $notification)
	{
		return 'Additional Document Deleted - Order on '
			.$notification->getOrder()->getProperty()->getDisplayAddress();
	}

	/**
	 * @param AbstractNotification|DeleteAdditionalDocumentNotification $notification
	 * @return array
	 */
	protected function getData(AbstractNotification $notification)
	{
		$data = parent::getData($notification);

		$data['document'] = $notification->getAdditionalDocument()->getDocument()->getName();

		return $data;
	}

	/**
	 * @return string
	 */
	protected function getTemplate()
	{
		return 'emails.appraisal.delete_additional_document';
	}
}