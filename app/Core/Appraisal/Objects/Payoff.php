<?php
namespace RealEstate\Core\Appraisal\Objects;
use RealEstate\Core\Customer\Objects\PayoffCreditCardRequisites;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class Payoff
{
    /**
     * @var float
     */
    private $amount;
    public function setAmount($amount) { $this->amount = $amount; }
    public function getAmount() { return $this->amount; }

    /**
     * @var PayoffCreditCardRequisites
     */
    private $creditCard;
    public function setCreditCard(PayoffCreditCardRequisites $requisites) { $this->creditCard = $requisites; }
    public function getCreditCard() { return $this->creditCard; }
}