<?php
namespace RealEstate\Api\Amc\V2_0\Processors;
use Restate\Libraries\Validation\Rules\Enum;
use RealEstate\Api\Support\BaseProcessor;
use RealEstate\Core\Payment\Enums\AccountType;
use RealEstate\Core\Payment\Objects\BankAccountRequisites;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class BankAccountProcessor extends BaseProcessor
{

    protected function configuration()
    {
        return [
            'accountType' => new Enum(AccountType::class),
            'routingNumber' => 'string',
            'accountNumber' => 'string',
            'nameOnAccount' => 'string',
            'bankName' => 'string',
            'address' => 'string',
            'city' => 'string',
            'state' => 'string',
            'zip' => 'string'
        ];
    }

    /**
     * @return BankAccountRequisites
     */
    public function createRequisites()
    {
        return $this->populate(new BankAccountRequisites());
    }
}