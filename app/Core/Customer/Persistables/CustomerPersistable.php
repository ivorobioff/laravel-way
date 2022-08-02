<?php
namespace RealEstate\Core\Customer\Persistables;

use RealEstate\Core\Customer\Enums\CompanyType;
use RealEstate\Core\User\Persistables\UserPersistable;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class CustomerPersistable extends UserPersistable
{
	/**
	 * @var string
	 */
	private $name;
	public function setName($name) { $this->name = $name; }
	public function getName() { return $this->name; }


	/**
	 * @var string
	 */
	private $phone;
	public function getPhone() { return $this->phone; }
	public function setPhone($phone) { $this->phone = $phone; }

	/**
	 * @var CompanyType
	 */
	private $companyType;
	public function getCompanyType() { return $this->companyType; }
	public function setCompanyType(CompanyType $companyType) { $this->companyType = $companyType; }
}