<?php
namespace RealEstate\Core\Appraisal\Notifications;

use RealEstate\Core\Appraisal\Entities\Document;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
abstract class AbstractDocumentNotification extends AbstractNotification
{
	/**
	 * @var Document
	 */
	private $document;

	/**
	 * @param Document $document
	 */
	public function __construct(Document $document)
	{
		parent::__construct($document->getOrder());
		$this->document = $document;
	}

	/**
	 * @return Document
	 */
	public function getDocument()
	{
		return $this->document;
	}
}