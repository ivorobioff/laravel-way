<?php
namespace RealEstate\Core\Appraisal\Validation;

use Restate\Libraries\Validation\AbstractThrowableValidator;
use Restate\Libraries\Validation\Binder;
use Restate\Libraries\Validation\Property;
use Restate\Libraries\Validation\Rules\Blank;
use Restate\Libraries\Validation\Rules\Greater;
use Restate\Libraries\Validation\Rules\Length;
use Restate\Libraries\Validation\Rules\Obligate;
use Restate\Libraries\Validation\Rules\Walk;
use RealEstate\Core\Customer\Entities\Customer;
use RealEstate\Core\Support\Service\ContainerInterface;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class ReconsiderationValidator extends AbstractThrowableValidator
{
    use AdditionalDocumentValidatorTrait;

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var Customer
     */
    private $customer;

    /**
     * @param ContainerInterface $container
     * @param Customer $customer
     */
    public function __construct(ContainerInterface $container, Customer $customer)
    {
        $this->container = $container;
        $this->customer = $customer;
    }

    /**
	 * @param Binder $binder
	 * @return void
	 */
	protected function define(Binder $binder)
	{
        $this->defineAdditionalDocument($binder, $this->container, $this->customer,
            ['namespace' => 'document']);

		$binder->bind('comparables', function(Property $property){
			$property->addRule(new Walk([$this, 'defineComparable']));
		});
	}

	/**
	 * @param Binder $binder
	 */
	public function defineComparable(Binder $binder)
	{
		$binder->bind('address', function(Property $property){
			$property
				->addRule(new Obligate())
				->addRule(new Blank())
				->addRule(new Length(1, 255));
		});

		$binder->bind('salesPrice', function(Property $property){
			$property
				->addRule(new Greater(0));
		});

		$binder->bind('livingArea', function(Property $property){
			$property
				->addRule(new Blank())
				->addRule(new Length(1, 255));
		});

		$binder->bind('siteSize', function(Property $property){
			$property
				->addRule(new Blank())
				->addRule(new Length(1, 255));
		});

		$binder->bind('actualAge', function(Property $property){
			$property
				->addRule(new Blank())
				->addRule(new Length(1, 255));
		});

		$binder->bind('distanceToSubject', function(Property $property){
			$property
				->addRule(new Blank())
				->addRule(new Length(1, 255));
		});

		$binder->bind('sourceData', function(Property $property){
			$property
				->addRule(new Blank())
				->addRule(new Length(1, 255));
		});
	}
}