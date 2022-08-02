<?php
namespace RealEstate\Core\Invitation\Entities;

use RealEstate\Core\Appraiser\Entities\Appraiser;
use RealEstate\Core\Customer\Entities\Customer;
use RealEstate\Core\Invitation\Enums\Requirements;
use RealEstate\Core\Invitation\Enums\Status;
use RealEstate\Core\Invitation\Properties\RequirementsPropertyTrait;
use RealEstate\Core\Shared\Properties\CreatedAtPropertyTrait;
use RealEstate\Core\Shared\Properties\IdPropertyTrait;
use RealEstate\Core\Asc\Entities\AscAppraiser;


/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class Invitation
{
	use IdPropertyTrait;
	use CreatedAtPropertyTrait;
	use RequirementsPropertyTrait;

    /**
     * @var Customer
     */
    private $customer;
    public function setCustomer(Customer $customer) { $this->customer = $customer; }
    public function getCustomer() { return $this->customer; }

	/**
	 * @var Appraiser
	 */
	private $appraiser;
	public function setAppraiser(Appraiser $appraiser = null) { $this->appraiser = $appraiser; }
	public function getAppraiser() { return $this->appraiser; }

	/**
	 * @var string
	 */
	private $reference;

	/**
	 * @var AscAppraiser
	 */
	private $ascAppraiser;

	/**
	 * @var Status
	 */
	private $status;

	public function __construct()
	{
		$this->setRequirements(new Requirements());
	}

	/**
	 * @param string $reference
	 */
	public function setReference($reference)
	{
		$this->reference = $reference;
	}

	/**
	 * @return string
	 */
	public function getReference()
	{
		return $this->reference;
	}

	/**
	 * @param AscAppraiser $appraiser
	 */
	public function setAscAppraiser(AscAppraiser $appraiser)
	{
		$this->ascAppraiser = $appraiser;
	}

	/**
	 * @return AscAppraiser
	 */
	public function getAscAppraiser()
	{
		return $this->ascAppraiser;
	}

	/**
	 * @param Status $status
	 */
	public function setStatus(Status $status)
	{
		$this->status = $status;
	}

	/**
	 * @return Status
	 */
	public function getStatus()
	{
		return $this->status;
	}
}