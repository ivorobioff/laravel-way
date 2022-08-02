<?php
namespace RealEstate\Core\Company\Validation;

use Restate\Libraries\Converter\Transferer\Transferer;
use Restate\Libraries\Validation\AbstractThrowableValidator;
use Restate\Libraries\Validation\Binder;
use Restate\Libraries\Validation\Property;
use Restate\Libraries\Validation\Rules\Blank;
use Restate\Libraries\Validation\Rules\Length;
use Restate\Libraries\Validation\Rules\Obligate;
use RealEstate\Core\Appraiser\Entities\Eo;
use RealEstate\Core\Appraiser\Persistables\EoPersistable;
use RealEstate\Core\Appraiser\Validation\Definers\EoDefiner;
use RealEstate\Core\Appraiser\Validation\Rules\Tin;
use RealEstate\Core\Company\Entities\Branch;
use RealEstate\Core\Company\Entities\Company;
use RealEstate\Core\Company\Persistables\BranchPersistable;
use RealEstate\Core\Company\Services\BranchService;
use RealEstate\Core\Company\Services\CompanyService;
use RealEstate\Core\Company\Validation\Rules\UniqueTaxId;
use RealEstate\Core\Document\Persistables\Identifier;
use RealEstate\Core\Location\Services\StateService;
use RealEstate\Core\Location\Validation\Definer\LocationDefiner;
use RealEstate\Core\Location\Validation\Rules\Zip;
use RealEstate\Core\Support\Service\ContainerInterface;

class BranchValidator extends AbstractThrowableValidator
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var CompanyService
     */
    private $companyService;

    /**
     * @var BranchService
     */
    private $branchService;

    /**
     * @var Company
     */
    private $currentCompany;

    /**
     * @var StateService
     */
    private $stateService;

    /**
     * @var Branch
     */
    private $currentBranch;

    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->companyService = $container->get(CompanyService::class);
        $this->branchService = $container->get(BranchService::class);
        $this->stateService = $container->get(StateService::class);
    }

    /**
     * @param Binder $binder
     */
    protected function define(Binder $binder)
    {
        $binder->bind('name', function (Property $property) {
            $property
                ->addRule(new Obligate())
                ->addRule(new Blank())
                ->addRule(new Length(1, 255));
        });

        $binder->bind('taxId', function (Property $property) {
            $property
                ->addRule(new Tin(Tin::TAX_ONLY))
                ->addRule(new UniqueTaxId(
                    $this->companyService, $this->currentCompany, $this->branchService, $this->currentBranch
                ));
        });

        (new LocationDefiner($this->stateService))->define($binder);

        $binder->bind('assignmentZip', function (Property $property) {
            $property
                ->addRule(new Obligate())
                ->addRule(new Zip());
        });

        $eo = new EoDefiner($this->container);

        $eo->setOnlyWhenSpecified(true);

        if ($eoDocument = object_take($this->currentBranch, 'eo.document')) {
            $eo->setTrustedDocument($eoDocument);
        }

        $eo->define($binder);
    }

    /**
     * @param BranchPersistable $source
     * @param Branch $branch
     */
    public function validateWithBranch(BranchPersistable $source, Branch $branch)
    {
        $persistable = new BranchPersistable();

        (new Transferer([
            'ignore' => [
                'state',
                'eo',
                'company',
                'staff'
            ]
        ]))->transfer($branch, $persistable);

        $persistable->setState($branch->getState()->getCode());

        if ($branch->getEo()) {
            $eoPersistable = new EoPersistable();

            (new Transferer([
                'ignore' => [
                    'document'
                ]
            ]))->transfer($branch->getEo(), $eoPersistable);

            if ($document = $branch->getEo()->getDocument()) {
                $eoPersistable->setDocument(new Identifier($document->getId()));
            }

            $persistable->setEo($eoPersistable);
        }

        (new Transferer([
            'nullable' => $this->getForcedProperties()
        ]))->transfer($source, $persistable);

        $this->validate($persistable);
    }

    /**
     * @param Company $company
     * @return $this
     */
    public function setCurrentCompany(Company $company)
    {
        $this->currentCompany = $company;
        return $this;
    }

    /**
     * @param Branch $branch
     * @return $this
     */
    public function setCurrentBranch(Branch $branch)
    {
        $this->currentBranch = $branch;
        return $this;
    }
}
