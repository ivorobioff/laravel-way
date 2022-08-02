<?php
namespace RealEstate\Core\Invitation\Validation;

use Restate\Libraries\Validation\AbstractThrowableValidator;
use Restate\Libraries\Validation\Binder;
use Restate\Libraries\Validation\Property;
use Restate\Libraries\Validation\Rules\Obligate;
use Restate\Libraries\Validation\SourceHandlerInterface;
use RealEstate\Core\Appraiser\Services\AppraiserService;
use RealEstate\Core\Appraiser\Validation\Rules\AppraiserExists;
use RealEstate\Core\Asc\Services\AscService;
use RealEstate\Core\Asc\Validation\Rules\AscAppraiserExists;
use RealEstate\Core\Customer\Entities\Customer;
use RealEstate\Core\Customer\Services\CustomerService;
use RealEstate\Core\Invitation\Validation\Rules\AppraiserNotConnected;
use RealEstate\Core\Invitation\Validation\Rules\AppraiserNotConnectedByAscAppraiser;
use RealEstate\Core\Invitation\Validation\Rules\AppraiserNotInvited;
use RealEstate\Core\Invitation\Validation\Rules\AppraiserNotInvitedByAscAppraiser;
use RealEstate\Core\Support\Service\ContainerInterface;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class InvitationValidator extends AbstractThrowableValidator
{
	/**
	 * @var CustomerService
	 */
	private $customerService;

	/**
	 * @var AscService
	 */
	private $ascService;

	/**
	 * @var AppraiserService
	 */
	private $appraiserService;

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
		$this->customerService = $container->get(CustomerService::class);
		$this->ascService = $container->get(AscService::class);
		$this->appraiserService = $container->get(AppraiserService::class);
		$this->customer = $customer;
	}

	/**
	 * @param Binder $binder
	 * @return void
	 */
	protected function define(Binder $binder)
	{
		$binder->bind('appraiser', function(Property $property){
			$property->addRule(new Obligate());
		})
			->when(function(SourceHandlerInterface $source){
				return $source->getValue('ascAppraiser') === null;
			});

		$binder->bind('ascAppraiser', function(Property $property){
			$property
				->addRule(new AscAppraiserExists($this->ascService))
				->addRule(new AppraiserNotInvitedByAscAppraiser($this->customerService, $this->ascService, $this->customer))
				->addRule(new AppraiserNotConnectedByAscAppraiser($this->customerService, $this->ascService, $this->customer));
		});

		$binder->bind('appraiser', function(Property $property){
			$property
				->addRule(new AppraiserExists($this->appraiserService))
				->addRule(new AppraiserNotInvited($this->appraiserService, $this->customer))
				->addRule(new AppraiserNotConnected($this->appraiserService, $this->customer));
		});
	}
}