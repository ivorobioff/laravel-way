<?php
namespace RealEstate\Core\Appraisal\Persistables;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class UpdateOrderPersistable extends AbstractOrderPersistable
{
	/**
	 * @var int
	 */
	private $contractDocument;
	public function setContractDocument($document) { $this->contractDocument = $document; }
	public function getContractDocument() { return $this->contractDocument; }
}