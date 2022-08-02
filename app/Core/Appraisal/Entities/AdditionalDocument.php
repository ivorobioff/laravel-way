<?php
namespace RealEstate\Core\Appraisal\Entities;

use RealEstate\Core\Customer\Entities\AdditionalDocumentType;
use RealEstate\Core\Document\Entities\Document as Source;
use RealEstate\Core\Document\Support\DocumentUsageManagementTrait;
use DateTime;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class AdditionalDocument
{
	use DocumentUsageManagementTrait;

	/**
	 * @var int
	 */
	private $id;
	public function setId($id) { $this->id = $id; }
	public function getId() { return $this->id; }

	/**
	 * @var DateTime
	 */
	private $createdAt;
	public function setCreatedAt(DateTime $datetime) { $this->createdAt = $datetime; }
	public function getCreatedAt() { return $this->createdAt; }

	/**
	 * @var Order
	 */
	private $order;
	public function setOrder(Order $order) { $this->order = $order; }
	public function getOrder() { return $this->order; }

	/**
	 * @var string
	 */
	private $label;
	public function setLabel($label) { $this->label = $label; }
	public function getLabel() { return $this->label; }

	/**
	 * @var Source
	 */
	private $document;
	public function getDocument() { return $this->document; }

	/**
	 * @param Source $document
	 */
	public function setDocument(Source $document = null)
	{
		$this->handleUsageOfOneDocument($this->getDocument(), $document);
		$this->document = $document;
	}

	/**
	 * @var AdditionalDocumentType
	 */
	private $type;
	public function setType(AdditionalDocumentType $type) { $this->type = $type; }
	public function getType() { return $this->type; }
}