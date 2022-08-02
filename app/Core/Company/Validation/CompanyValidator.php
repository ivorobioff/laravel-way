<?php
namespace RealEstate\Core\Company\Validation;
use Restate\Libraries\Validation\AbstractThrowableValidator;
use Restate\Libraries\Validation\Binder;
use Restate\Libraries\Validation\Property;
use Restate\Libraries\Validation\Rules\Blank;
use Restate\Libraries\Validation\Rules\Length;
use Restate\Libraries\Validation\Rules\Obligate;
use RealEstate\Core\Appraiser\Validation\Definers\AchDefiner;
use RealEstate\Core\Appraiser\Validation\Definers\EoDefiner;
use RealEstate\Core\Appraiser\Validation\Rules\Tin;
use RealEstate\Core\Company\Entities\Company;
use RealEstate\Core\Company\Services\BranchService;
use RealEstate\Core\Company\Services\CompanyService;
use RealEstate\Core\Company\Validation\Rules\UniqueTaxId;
use RealEstate\Core\Document\Validation\DocumentInflator;
use RealEstate\Core\Location\Services\StateService;
use RealEstate\Core\Location\Validation\Definer\LocationDefiner;
use RealEstate\Core\Location\Validation\Rules\Zip;
use RealEstate\Core\Shared\Validation\Rules\Phone;
use RealEstate\Core\Support\Service\ContainerInterface;
use RealEstate\Core\User\Validation\Inflators\EmailInflator;
use RealEstate\Core\User\Validation\Inflators\FirstNameInflator;
use RealEstate\Core\User\Validation\Inflators\LastNameInflator;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class CompanyValidator extends AbstractThrowableValidator
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
     * @var Company
     */
    private $currentCompany;

    /**
     * @var StateService
     */
    private $stateService;

    /**
     * @var BranchService
     */
    private $branchService;

    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->companyService = $container->get(CompanyService::class);
        $this->stateService = $container->get(StateService::class);
        $this->branchService = $container->get(BranchService::class);
    }

    /**
     * @param Binder $binder
     * @return void
     */
    protected function define(Binder $binder)
    {
        $binder->bind('name', function(Property $property){
            $property
                ->addRule(new Obligate())
                ->addRule(new Blank())
                ->addRule(new Length(1, 255));
        });

        $binder->bind('type', function(Property $property){
            $property->addRule(new Obligate());
        });

        $binder->bind('taxId', function(Property $property){
            $property
                ->addRule(new Obligate())
                ->addRule(new Tin(Tin::TAX_ONLY))
                ->addRule(new UniqueTaxId($this->companyService, $this->currentCompany, $this->branchService));
        });

        $inflator = new DocumentInflator($this->container);

        if ($w9 = object_take($this->currentCompany, 'w9')){
            $inflator->setTrustedDocuments([$w9]);
        }

        $inflator->setRequired(true);

        $binder->bind('w9', $inflator);

        $binder->bind('firstName', new FirstNameInflator());
        $binder->bind('lastName', new LastNameInflator());
        $binder->bind('email', new EmailInflator());

        $binder->bind('phone', function (Property $property) {
            $property
                ->addRule(new Obligate())
                ->addRule(new Phone());
        });

        $binder->bind('fax', function (Property $property) {
            $property
                ->addRule(new Phone());
        });

        (new LocationDefiner($this->stateService))->define($binder);

        $binder->bind('assignmentZip', function (Property $property) {
            $property->addRule(new Obligate())
                ->addRule(new Zip());
        });

        (new AchDefiner())->setNamespace('ach')->define($binder);

        $eo = new EoDefiner($this->container);

        $eo->setOnlyWhenSpecified(true);

        if ($eoDocument = object_take($this->currentCompany, 'eo.document')){
            $eo->setTrustedDocument($eoDocument);
        }

        $eo->define($binder);
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
}