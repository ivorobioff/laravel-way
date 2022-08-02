<?php
namespace RealEstate\Core\Payment\Objects;

use RealEstate\Core\Shared\Objects\MonthYearPair;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class CreditCardRequisites extends AbstractRequisites
{
	/**
	 * @var string
	 */
	private $number;
    public function getNumber() { return $this->number; }
    public function setNumber($number) { $this->number = $number; }

	/**
	 * @var MonthYearPair
	 */
	private $expiresAt;
    public function getExpiresAt() { return $this->expiresAt; }
    public function setExpiresAt(MonthYearPair $expiresAt) { $this->expiresAt = $expiresAt; }

	/**
	 * @var string
	 */
	private $code;
	public function getCode() { return $this->code; }
	public function setCode($code) { $this->code = $code; }
}