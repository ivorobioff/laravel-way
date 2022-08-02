<?php
namespace RealEstate\Letter\Handlers\Appraisal;

use RealEstate\Core\Appraisal\Emails\AppraiserDocumentEmail;
use RealEstate\Core\Appraisal\Entities\Order;
use RealEstate\Core\Document\Entities\Document;
use RealEstate\Letter\Support\Job;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class AppraiserDocumentEmailHandler extends AbstractAppraiserDocumentEmailHandler
{
	/**
	 * @param AppraiserDocumentEmail $source
	 * @return Order
	 */
	protected function getOrder($source)
	{
		return $source->getDocument()->getOrder();
	}

	/**
	 * @param AppraiserDocumentEmail $source
	 * @return Document
	 */
	protected function getDocument($source)
	{
		return $source->getDocument()->getPrimary();
	}
}