<?php
namespace RealEstate\Core\Appraisal\Validation;

use Restate\Libraries\Validation\AbstractThrowableValidator;
use Restate\Libraries\Validation\Binder;
use RealEstate\Core\Customer\Entities\Customer;
use RealEstate\Core\Support\Service\ContainerInterface;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class AdditionalDocumentValidator extends AbstractThrowableValidator
{
	use AdditionalDocumentValidatorTrait;

	/**
	 * @var Customer
	 */
	private $customer;

	/**
	 * @var ContainerInterface
	 */
	private $container;

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
		$this->defineAdditionalDocument($binder, $this->container, $this->customer);
	}
}