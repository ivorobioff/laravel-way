<?php
namespace RealEstate\Api\Customer\V2_0\Processors;
use RealEstate\Api\Support\BaseProcessor;
use RealEstate\Api\Support\Validation\Rules\MonthYearPair;
use RealEstate\Core\Appraisal\Objects\CreditCard;
use RealEstate\Core\Appraisal\Objects\Payoff;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class PayoffProcessor extends BaseProcessor
{
    /**
     * @return array
     */
    protected function configuration()
    {
        return [
            'creditCard' => 'array',
            'creditCard.firstName' => 'string',
            'creditCard.lastName' => 'string',
            'creditCard.number' => 'string',
            'creditCard.code' => 'string',
            'creditCard.expiresAt' => new MonthYearPair(),
            'creditCard.address' => 'string',
            'creditCard.city' => 'string',
            'creditCard.state' => 'string',
            'creditCard.zip' => 'string',
            'creditCard.email' => 'string',
            'creditCard.phone' => 'string',
            'amount' => 'float'
        ];
    }

    /**
     * @return Payoff
     */
    public function createPayoff()
    {
        return $this->populate(new Payoff());
    }
}