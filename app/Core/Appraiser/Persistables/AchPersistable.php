<?php
namespace RealEstate\Core\Appraiser\Persistables;

use RealEstate\Core\Appraiser\Enums\AchAccountType;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class AchPersistable
{
	/**
	 * @var string
	 */
	private $bankName;
	public function getBankName() { return $this->bankName; }
	public function setBankName($name) { $this->bankName = $name; }

	/**
	 * @var AchAccountType
	 */
	private $accountType;
	public function getAccountType() { return $this->accountType; }
	public function setAccountType(AchAccountType $type) {$this->accountType = $type; }

	/**
	 * @var string
	 */
	private $routing;
	public function getRouting() { return $this->routing; }
	public function setRouting($routing) { $this->routing = $routing; }

	/**
	 * @var string
	 */
	private $accountNumber;
	public function getAccountNumber() { return $this->accountNumber; }
	public function setAccountNumber($number) { $this->accountNumber = $number; }
}