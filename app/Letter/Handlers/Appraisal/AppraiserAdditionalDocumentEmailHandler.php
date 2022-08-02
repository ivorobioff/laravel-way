<?php
namespace RealEstate\Letter\Handlers\Appraisal;

use RealEstate\Core\Appraisal\Emails\AppraiserAdditionalDocumentEmail;
use RealEstate\Core\Appraisal\Entities\Order;
use RealEstate\Core\Document\Entities\Document;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class AppraiserAdditionalDocumentEmailHandler extends AbstractAppraiserDocumentEmailHandler
{
	/**
	 * @param AppraiserAdditionalDocumentEmail $source
	 * @return Order
	 */
	protected function getOrder($source)
	{
		return $source->getAdditionalDocument()->getOrder();
	}

	/**
	 * @param AppraiserAdditionalDocumentEmail $source
	 * @return Document
	 */
	protected function getDocument($source)
	{
		return $source->getAdditionalDocument()->getDocument();
	}
}