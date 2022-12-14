<?php
namespace RealEstate\Core\Appraiser\Persistables;

use RealEstate\Core\Appraiser\Enums\CommercialExpertiseCollection;
use RealEstate\Core\Document\Persistables\Identifier;
use RealEstate\Core\Shared\Objects\MonthYearPair;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class QualificationsPersistable
{
	/**
	 * @var MonthYearPair
	 */
	private $certifiedAt;
	public function setCertifiedAt(MonthYearPair $certifiedAt = null) { $this->certifiedAt = $certifiedAt; }
	public function getCertifiedAt() { return $this->certifiedAt; }

	/**
	 * @var int
	 */
	private $yearsLicensed;
	public function setYearsLicensed($yearsLicensed) { $this->yearsLicensed = $yearsLicensed; }
	public function getYearsLicensed() { return $this->yearsLicensed; }

	/**
	 * @var bool
	 */
	private $vaQualified;
	public function setVaQualified($flag) { $this->vaQualified = $flag; }
	public function getVaQualified() { return $this->vaQualified; }

	/**
	 * @var bool
	 */
	private $fhaQualified;
	public function setFhaQualified($flag) { $this->fhaQualified = $flag; }
	public function getFhaQualified() { return $this->fhaQualified; }

	/**
	 * @var bool
	 */
	private $relocationQualified;
	public function setRelocationQualified($flag) { $this->relocationQualified = $flag; }
	public function getRelocationQualified() { return $this->relocationQualified; }

	/**
	 * @var bool
	 */
	private $usdaQualified;
	public function setUsdaQualified($flag) { $this->usdaQualified = $flag; }
	public function getUsdaQualified() { return $this->usdaQualified; }

	/**
	 * @var bool
	 */
	private $coopQualified;
	public function setCoopQualified($flag) { $this->coopQualified = $flag; }
	public function getCoopQualified() { return $this->coopQualified; }

	/**
	 * @var bool
	 */
	private $jumboQualified;
	public function setJumboQualified($flag) { $this->jumboQualified = $flag; }
	public function getJumboQualified() { return $this->jumboQualified; }

	/**
	 * @var bool
	 */
	private $newConstructionQualified;
	public function setNewConstructionQualified($flag) { $this->newConstructionQualified = $flag; }
	public function getNewConstructionQualified() { return $this->newConstructionQualified; }

	/**
	 * @var int
	 */
	private $newConstructionExperienceInYears;
	public function getNewConstructionExperienceInYears() { return $this->newConstructionExperienceInYears; }
	public function setNewConstructionExperienceInYears($years) { $this->newConstructionExperienceInYears = $years; }

	/**
	 * @var int
	 */
	private $numberOfNewConstructionCompleted;
	public function getNumberOfNewConstructionCompleted() { return $this->numberOfNewConstructionCompleted; }
	public function setNumberOfNewConstructionCompleted($number) { $this->numberOfNewConstructionCompleted = $number; }

	/**
	 * @var bool
	 */
	private $isNewConstructionCourseCompleted;
	public function isNewConstructionCourseCompleted() { return $this->isNewConstructionCourseCompleted; }
	public function setNewConstructionCourseCompleted($flag) { $this->isNewConstructionCourseCompleted = $flag; }

	/**
	 * @var bool
	 */
	private $isFamiliarWithFullScopeInNewConstruction;
	public function isFamiliarWithFullScopeInNewConstruction() { return $this->isFamiliarWithFullScopeInNewConstruction; }
	public function setFamiliarWithFullScopeInNewConstruction($flag) { $this->isFamiliarWithFullScopeInNewConstruction = $flag; }

	/**
	 * @var bool
	 */
	private $loan203KQualified;
	public function setLoan203KQualified($flag) { $this->loan203KQualified = $flag; }
	public function getLoan203KQualified() { return $this->loan203KQualified; }

	/**
	 * @var bool
	 */
	private $manufacturedHomeQualified;
	public function setManufacturedHomeQualified($flag) { $this->manufacturedHomeQualified = $flag; }
	public function getManufacturedHomeQualified() { return $this->manufacturedHomeQualified; }

	/**
	 * @var bool
	 */
	private $reoQualified;
	public function setReoQualified($flag) { $this->reoQualified = $flag; }
	public function getReoQualified() { return $this->reoQualified; }

	/**
	 * @var bool
	 */
	private $deskReviewQualified;
	public function setDeskReviewQualified($flag) { $this->deskReviewQualified = $flag; }
	public function getDeskReviewQualified() { return $this->deskReviewQualified; }

	/**
	 * @var bool
	 */
	private $fieldReviewQualified;
	public function setFieldReviewQualified($flag) { $this->fieldReviewQualified = $flag; }
	public function getFieldReviewQualified() { return $this->fieldReviewQualified; }

	/**
	 * @var bool
	 */
	private $envCapable;
	public function setEnvCapable($flag) { $this->envCapable = $flag; }
	public function getEnvCapable() { return $this->envCapable; }

	/**
	 * @var bool
	 */
	private $commercialQualified;
	public function setCommercialQualified($flag) { $this->commercialQualified = $flag; }
	public function getCommercialQualified() { return $this->commercialQualified; }

	/**
	 * @var CommercialExpertiseCollection
	 */
	private $commercialExpertise;
	public function getCommercialExpertise() { return $this->commercialExpertise; }
	public function setCommercialExpertise(CommercialExpertiseCollection $collection) { $this->commercialExpertise = $collection; }

	/**
	 * @var string
	 */
	private $otherCommercialExpertise;
	public function getOtherCommercialExpertise() { return $this->otherCommercialExpertise; }
	public function setOtherCommercialExpertise($otherCommercialExpertise) { $this->otherCommercialExpertise = $otherCommercialExpertise; }

	/**
	 * @var LicensePersistable
	 */
	private $primaryLicense;
	public function getPrimaryLicense() { return $this->primaryLicense; }
	public function setPrimaryLicense(LicensePersistable $primaryLicense) { $this->primaryLicense = $primaryLicense; }

	/**
	 * @var Identifier
	 */
	private $resume;
	public function getResume() { return $this->resume; }
	public function setResume(Identifier $resume) { $this->resume = $resume; }
}