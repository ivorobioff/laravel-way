<?php
namespace RealEstate\Core\Company\Validation\Rules;

use Restate\Libraries\Validation\Error;
use Restate\Libraries\Validation\Rules\AbstractRule;
use RealEstate\Core\Company\Entities\Company;
use RealEstate\Core\Company\Services\BranchService;
use RealEstate\Core\Company\Services\InvitationService;

class AppraiserNotInvitedToCompany extends AbstractRule
{
    /**
     * @var InvitationService
     */
    private $invitationService;

    /**
     * @var BranchService
     */
    private $branchService;

    /**
     * @var Company
     */
    private $company;

    /**
     * @param InvitationService $invitationService
     * @param BranchService $branchService
     * @param Company $company
     */
    public function __construct(
        InvitationService $invitationService,
        BranchService $branchService,
        Company $company
    ) {
        $this->invitationService = $invitationService;
        $this->branchService = $branchService;
        $this->company = $company;

        $this->setIdentifier('already-invited');
        $this->setMessage('Appraiser has already been invited to the company.');
    }

    /**
     * @param int $value
     * @return Error|null
     */
    public function check($value)
    {
        $branches = $this->branchService->getAll($this->company->getId());
        $branchIds = array_map(function ($branch) {
            return $branch->getId();
        }, $branches);

        if ($this->invitationService->existsByAscAppraiser($value, $branchIds)) {
            return $this->getError();
        }

        return null;
    }
}
