<?php
namespace RealEstate\Core\Appraisal\Notifications;

use RealEstate\Core\Appraisal\Entities\AdditionalDocument;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
abstract class AbstractAdditionalDocumentNotification extends AbstractNotification
{
	/**
	 * @var AdditionalDocument
	 */
	private $additionalDocument;

	public function __construct(AdditionalDocument $additionalDocument)
	{
		parent::__construct($additionalDocument->getOrder());
		$this->additionalDocument = $additionalDocument;
	}

	/**
	 * @return AdditionalDocument
	 */
	public function getAdditionalDocument()
	{
		return $this->additionalDocument;
	}
}