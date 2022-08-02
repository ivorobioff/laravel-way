<?php
namespace RealEstate\Core\Appraisal\Emails;

use RealEstate\Core\Appraisal\Entities\Document;
use RealEstate\Core\Support\Letter\Email;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class AppraiserDocumentEmail extends Email
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