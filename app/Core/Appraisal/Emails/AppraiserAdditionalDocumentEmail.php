<?php
namespace RealEstate\Core\Appraisal\Emails;

use RealEstate\Core\Appraisal\Entities\AdditionalDocument;
use RealEstate\Core\Support\Letter\Email;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class AppraiserAdditionalDocumentEmail extends Email
{
	/**
	 * @var AdditionalDocument
	 */
	private $additionalDocument;

	/**
	 * @param AdditionalDocument $additionalDocument
	 */
	public function __construct(AdditionalDocument $additionalDocument)
	{
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