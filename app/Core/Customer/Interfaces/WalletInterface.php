<?php
namespace RealEstate\Core\Customer\Interfaces;
use RealEstate\Core\Customer\Objects\PayoffCreditCardRequisites;
use RealEstate\Core\Customer\Objects\PayoffPurchase;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
interface WalletInterface
{
    /**
     * @param PayoffCreditCardRequisites $requisites
     * @param PayoffPurchase $purchase
     */
    public function pay(PayoffCreditCardRequisites $requisites, PayoffPurchase $purchase);
}