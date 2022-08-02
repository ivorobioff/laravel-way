<?php
namespace RealEstate\Core\Company\Validation\Rules;

use Restate\Libraries\Validation\Error;
use Restate\Libraries\Validation\Rules\AbstractRule;
use RealEstate\Core\Company\Entities\Company;
use RealEstate\Core\Company\Services\CompanyService;

class AppraiserNotInCompany extends AbstractRule
{
    /**
     * @var CompanyService
     */
    private $companyService;

    /**
     * @var Company
     */
    private $company;

    /**
     * @param CompanyService $companyService
     */
    public function __construct(CompanyService $companyService, Company $company)
    {
        $this->companyService = $companyService;
        $this->company = $company;

        $this->setIdentifier('already-in-company');
        $this->setMessage('Appraiser is already part of the company.');
    }

    /**
     * @param int $value
     * @return Error|null
     */
    public function check($value)
    {
        if ($this->companyService->hasStaff($this->company->getId(), $value)) {
            return $this->getError();
        }

        return null;
    }
}
