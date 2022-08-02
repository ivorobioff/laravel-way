<?php
namespace RealEstate\Core\Company\Validation\Rules;
use Restate\Libraries\Validation\Error;
use Restate\Libraries\Validation\Rules\AbstractRule;
use Restate\Libraries\Validation\Value;
use RealEstate\Core\Company\Entities\Company;
use RealEstate\Core\Company\Services\CompanyService;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class BranchExists extends AbstractRule
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
     * @param Company $company
     */
    public function __construct(CompanyService $companyService, $company)
    {
        $this->companyService = $companyService;
        $this->company = $company;

        $this->setIdentifier('exists')->setMessage('The provided branch does not belong to the provided company.');
    }

    /**
     * @param mixed|Value $value
     * @return Error|null
     */
    public function check($value)
    {
        if (!$this->companyService->hasBranch($this->company->getId(), $value)){
            return $this->getError();
        }

        return null;
    }
}