<?php
namespace RealEstate\Core\Payment\Objects;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class CreditCard extends AbstractPaymentMethod
{
    /**
     * @var string
     */
    private $number;
    public function getNumber() { return $this->number; }
    public function setNumber($number) { $this->number = $number; }
}