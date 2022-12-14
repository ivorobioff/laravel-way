<?php
namespace RealEstate\Core\Customer\Entities;

use Doctrine\Common\Collections\ArrayCollection;
use RealEstate\Core\Amc\Entities\Amc;
use RealEstate\Core\Appraiser\Entities\Appraiser;
use RealEstate\Core\Customer\Enums\CompanyType;
use RealEstate\Core\User\Entities\User;
use RealEstate\Core\User\Interfaces\PhoneHolderInterface;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class Customer extends User implements PhoneHolderInterface
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

	/**
	 * @var Appraiser[]
	 */
	private $appraisers;
	public function getAppraisers() { return $this->appraisers; }

	/**
	 * @param Appraiser $appraiser
	 */
	public function addAppraiser(Appraiser $appraiser)
	{
		$this->appraisers->add($appraiser);
		$appraiser->addCustomer($this);
	}

	/**
	 * @var Amc[]
	 */
	private $amcs;
	public function getAmcs() { return $this->amcs; }

	/**
	 * @param Amc $amc
	 */
	public function addAmc(Amc $amc)
	{
		$this->amcs->add($amc);
		$amc->addCustomer($this);
	}
	
	/**
	 * @var Settings
	 */
	private $settings;

	/**
	 * @return Settings
	 */
	public function getSettings() { return $this->settings->first()?:null; }


	/**
	 * @param Settings $settings
	 */
	public function setSettings(Settings $settings)
	{
		$this->settings->clear();
		$this->settings->add($settings);
	}

	/**
	 * @var string
	 */
	private $secret1;
	public function setSecret1($secret) { $this->secret1 = $secret; }
	public function getSecret1() { return $this->secret1; }

	/**
	 * @var string
	 */
	private $secret2;
	public function setSecret2($secret) { $this->secret2 = $secret; }
	public function getSecret2() { return $this->secret2; }

	/**
	 * @return string
	 */
	public function getDisplayName() { return $this->getName(); }


	public function __construct()
	{
		parent::__construct();
		
		$this->appraisers = new ArrayCollection();
		$this->amcs = new ArrayCollection();
		$this->settings = new ArrayCollection();
		$this->setCompanyType(new CompanyType(CompanyType::APPRAISAL_MANAGEMENT_COMPANY));
	}
}