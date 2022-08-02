<?php
namespace RealEstate\Core\Payment\Interfaces;

use RealEstate\Core\Payment\Enums\Means;
use RealEstate\Core\Payment\Objects\Charge;
use RealEstate\Core\Payment\Objects\Purchase;
use RealEstate\Core\Payment\Objects\ReferencesTuple;
use RealEstate\Core\Payment\Objects\BankAccountRequisites;
use RealEstate\Core\Payment\Objects\CreditCardRequisites;
use RealEstate\Core\User\Entities\User;
use RealEstate\Core\Payment\Entities\ProfileReference;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
interface PaymentSystemInterface
{
	/**
	 * @param User $owner
	 * @param CreditCardRequisites $requisites
	 * @return ReferencesTuple
	 */
	public function createProfileWithCreditCard(User $owner, CreditCardRequisites $requisites);

	/**
	 * @param ProfileReference $reference
	 * @param CreditCardRequisites $requisites
     * @return null|string
	 */
	public function replaceCreditCard(ProfileReference $reference, CreditCardRequisites $requisites);

    /**
     * @param User $owner
     * @param BankAccountRequisites $requisites
     * @return ReferencesTuple
     */
    public function createProfileWithBankAccount(User $owner, BankAccountRequisites $requisites);

    /**
     * @param ProfileReference $reference
     * @param BankAccountRequisites $requisites
     * @param null|string
     */
    public function replaceBankAccount(ProfileReference $reference, BankAccountRequisites $requisites);

	/**
	 * @param ProfileReference $reference
     * @param Purchase $purchase
     * @param Means $means
	 * @return Charge
	 */
	public function charge(ProfileReference $reference, Purchase $purchase, Means $means);

    /**
     * @param ProfileReference $reference
     * @param User $owner
     */
    public function refreshProfile(ProfileReference $reference, User $owner);
}