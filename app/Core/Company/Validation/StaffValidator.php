<?php
namespace RealEstate\Core\Company\Validation;

use Restate\Libraries\Validation\AbstractThrowableValidator;
use Restate\Libraries\Validation\Binder;
use Restate\Libraries\Validation\Property;
use Restate\Libraries\Validation\Rules\Blank;
use Restate\Libraries\Validation\Rules\Email;
use Restate\Libraries\Validation\Rules\Length;
use Restate\Libraries\Validation\Rules\Obligate;
use RealEstate\Core\Company\Entities\Company;
use RealEstate\Core\Company\Services\CompanyService;
use RealEstate\Core\Company\Validation\Rules\BranchExists;
use RealEstate\Core\Shared\Validation\Rules\Phone;
use RealEstate\Core\Support\Service\ContainerInterface;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class StaffValidator extends AbstractThrowableValidator
{
    /**
     * @var Company
     */
    protected $company;

    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @param ContainerInterface $container
     * @param Company $company
     */
    public function __construct(ContainerInterface $container, $company)
    {
        $this->container = $container;
        $this->company = $company;
    }

    /**
     * @param Binder $binder
     * @return void
     */
    protected function define(Binder $binder)
    {
        $binder->bind('email', function (Property $property) {
            $property
                ->addRule(new Blank())
                ->addRule(new Length(1, 255))
                ->addRule(new Email());
        });

        $binder->bind('phone', function(Property $property){
            $property
                ->addRule(new Phone());
        });

        $binder->bind('branch', function(Property $property){
            $property
                ->addRule(new Obligate())
                ->addRule(new BranchExists($this->container->get(CompanyService::class), $this->company));
        });
    }
}