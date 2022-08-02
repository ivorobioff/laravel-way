<?php
namespace RealEstate\Core\Appraiser\Persistables;

use RealEstate\Core\Appraiser\Entities\Coverage;
use RealEstate\Core\Asc\Enums\Certifications;
use RealEstate\Core\Assignee\Support\CoverageManagement;
use RealEstate\Core\Document\Persistables\Identifier;
use DateTime;

/**
 *
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class LicensePersistable
{
    /**
     * @var string
     */
    private $number;
    public function setNumber($number) { $this->number = $number; }
    public function getNumber() { return $this->number; }

    /**
     * @var Certifications
     */
    private $certifications;
    public function setCertifications(Certifications $certifications) { $this->certifications = $certifications; }
    public function getCertifications() { return $this->certifications; }

    /**
     * @var string
     */
    private $state;
    public function setState($state) { $this->state = $state; }
    public function getState() { return $this->state; }

    /**
     * @var DateTime
     */
    private $expiresAt;
    public function setExpiresAt(DateTime $datetime) { $this->expiresAt = $datetime; }
    public function getExpiresAt() { return $this->expiresAt; }

    /**
     * @var bool
     */
    private $isFhaApproved;
    public function setFhaApproved($flag) { $this->isFhaApproved = $flag; }
    public function isFhaApproved() { return $this->isFhaApproved; }

    /**
     * @var bool
     */
    private $isCommercial;
    public function setCommercial($flag) { $this->isCommercial = $flag; }
    public function isCommercial() { return $this->isCommercial; }

    /**
     * @var Identifier
     */
    private $document;
    public function setDocument(Identifier $identifier) { $this->document = $identifier; }
    public function getDocument() { return $this->document; }

    /**
     *
     * @var CoveragePersistable[]
     */
    private $coverages;
    public function setCoverages(array $coverages) { $this->coverages = $coverages; }
    public function getCoverages() { return $this->coverages; }

	/**
	 * @param Coverage[] $coverages
	 */
	public function adaptCoverages($coverages)
	{
		$this->setCoverages(CoverageManagement::asPersistables($coverages, CoveragePersistable::class));
	}
}