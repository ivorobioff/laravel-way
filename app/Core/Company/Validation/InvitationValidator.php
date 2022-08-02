<?php
namespace RealEstate\Core\Company\Validation;

use Restate\Libraries\Validation\AbstractThrowableValidator;
use Restate\Libraries\Validation\Binder;
use Restate\Libraries\Validation\Property;
use Restate\Libraries\Validation\Rules\Obligate;
use RealEstate\Core\Asc\Services\AscService;
use RealEstate\Core\Asc\Validation\Rules\AscAppraiserExists;
use RealEstate\Core\Company\Entities\Company;
use RealEstate\Core\Company\Services\BranchService;
use RealEstate\Core\Company\Services\CompanyService;
use RealEstate\Core\Company\Services\InvitationService;
use RealEstate\Core\Company\Validation\Rules\AppraiserNotInCompany;
use RealEstate\Core\Company\Validation\Rules\AppraiserNotInvitedToCompany;
use RealEstate\Core\Shared\Validation\Rules\Phone;
use RealEstate\Core\Support\Service\ContainerInterface;
use RealEstate\Core\User\Validation\Inflators\EmailInflator;

class InvitationValidator extends AbstractThrowableValidator
{
    /**
     * @var AscService
     */
    private $ascService;

    /**
     * @var CompanyService
     */
    private $companyService;

    /**
     * @var BranchService
     */
    private $branchService;

    /**
     * @var InvitationService
     */
    private $invitationService;

    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->ascService = $container->get(AscService::class);
        $this->companyService = $container->get(CompanyService::class);
        $this->branchService = $container->get(BranchService::class);
        $this->invitationService = $container->get(InvitationService::class);
    }

    /**
     * @param Binder $binder
     */
    protected function define(Binder $binder)
    {
        $binder->bind('ascAppraiser', function (Property $property) {
            $property
                ->addRule(new Obligate())
                ->addRule(new AscAppraiserExists($this->ascService))
                ->addRule(new AppraiserNotInvitedToCompany($this->invitationService, $this->branchService, $this->company))
                ->addRule(new AppraiserNotInCompany($this->companyService, $this->company));
        });

        $binder->bind('email', new EmailInflator());

        $binder->bind('phone', function (Property $property) {
            $property
                ->addRule(new Obligate())
                ->addRule(new Phone());
        });
    }

    /**
     * @param Company $company
     * @return $this
     */
    public function setCompany(Company $company)
    {
        $this->company = $company;
        return $this;
    }
}
