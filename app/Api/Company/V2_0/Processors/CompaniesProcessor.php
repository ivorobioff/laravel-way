<?php
namespace RealEstate\Api\Company\V2_0\Processors;

use Restate\Libraries\Validation\Rules\Enum;
use RealEstate\Api\Support\BaseProcessor;
use RealEstate\Core\Appraiser\Enums\CompanyType;
use RealEstate\Core\Company\Persistables\CompanyPersistable;
use RealEstate\Core\Payment\Enums\AccountType;

class CompaniesProcessor extends BaseProcessor
{
    /**
     * @return array
     */
    protected function configuration()
    {
        return [
            'name' => 'string',
            'firstName' => 'string',
            'lastName' => 'string',
            'email' => 'string',
            'phone' => 'string',
            'fax' => 'string',
            'address1' => 'string',
            'address2' => 'string',
            'city' => 'string',
            'zip' => 'string',
            'assignmentZip' => 'string',
            'state' => 'string',
            'w9' => 'document',
            'taxId' => 'string',
            'type' => new Enum(CompanyType::class),
            'otherType' => 'string',
            'eo.document' => 'document',
            'eo.claimAmount' => 'float',
            'eo.aggregateAmount' => 'float',
            'eo.expiresAt' => 'datetime',
            'eo.carrier' => 'string',
            'eo.deductible' => 'float',
            'ach.bankName' => 'string',
            'ach.accountType' => new Enum(AccountType::class),
            'ach.accountNumber' => 'string',
            'ach.routing' => 'string'
        ];
    }

    /**
     * @return CompanyPersistable
     */
    public function createPersistable()
    {
        return $this->populate(new CompanyPersistable());
    }
}
