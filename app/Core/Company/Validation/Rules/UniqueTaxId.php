<?php
namespace RealEstate\Core\Company\Validation\Rules;
use Restate\Libraries\Validation\Error;
use Restate\Libraries\Validation\Rules\AbstractRule;
use Restate\Libraries\Validation\Value;
use RealEstate\Core\Company\Entities\Branch;
use RealEstate\Core\Company\Entities\Company;
use RealEstate\Core\Company\Services\BranchService;
use RealEstate\Core\Company\Services\CompanyService;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class UniqueTaxId extends AbstractRule
{
    /**
     * @var CompanyService
     */
    private $companyService;

    /**
     * @var Company
     */
    private $currentCompany;

    /**
     * @var BranchService
     */
    private $branchService;

    /**
     * @var Branch
     */
    private $currentBranch;

    /**
     * @param CompanyService $companyService
     * @param Company $currentCompany
     * @param BranchService $branchService
     * @param Branch $currentBranch
     */
    public function __construct(
        CompanyService $companyService,
        Company $currentCompany = null,
        BranchService $branchService = null,
        Branch $currentBranch = null
    ) {
        $this->companyService = $companyService;
        $this->currentCompany = $currentCompany;
        $this->branchService = $branchService;
        $this->currentBranch = $currentBranch;

        $this->setIdentifier('unique');
        $this->setMessage('The provided tax id is already registered.');
    }

    /**
     * @param mixed|Value $value
     * @return Error|null
     */
    public function check($value)
    {
        if ($this->currentCompany && $this->currentCompany->getTaxId() === $value){
            return null;
        }

        if ($this->companyService->existsWithTaxId($value)){
            return $this->getError();
        }

        if ($this->currentBranch && $this->currentBranch->getTaxId() === $value) {
            return null;
        }

        $companyId = $this->currentCompany ? $this->currentCompany->getId() : null;

        if ($this->branchService->existsWithTaxId($value, $companyId)) {
            return $this->getError();
        }

        return null;
    }
}