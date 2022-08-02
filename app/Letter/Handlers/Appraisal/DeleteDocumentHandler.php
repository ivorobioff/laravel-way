<?php
namespace RealEstate\Letter\Handlers\Appraisal;

use RealEstate\Core\Appraisal\Notifications\AbstractNotification;
use RealEstate\Core\Appraisal\Notifications\CreateDocumentNotification;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class DeleteDocumentHandler extends AbstractOrderHandler
{
	/**
	 * @param AbstractNotification|CreateDocumentNotification $notification
	 * @return string
	 */
	protected function getSubject(AbstractNotification $notification)
	{
		return 'Document Deleted - Order on '
			.$notification->getOrder()->getProperty()->getDisplayAddress();
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
	 * @return string
	 */
	protected function getTemplate()
	{
		return 'emails.appraisal.delete_document';
	}
}