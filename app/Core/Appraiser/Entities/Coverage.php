<?php
namespace RealEstate\Core\Appraiser\Entities;

use RealEstate\Core\Assignee\Interfaces\CoverageInterface;
use RealEstate\Core\Assignee\Interfaces\CoverageStorableInterface;
use RealEstate\Core\Location\Entities\County;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class Coverage implements CoverageInterface
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var County
     */
    private $county;
    public function setCounty(County $county) { $this->county = $county; }
    public function getCounty() { return $this->county; }

    /**
     * @var string
     */
    private $zip;
    public function setZip($zip) { $this->zip = $zip; }
    public function getZip() { return $this->zip; }

	/**
	 * @var License|CoverageStorableInterface
	 */
	private $license;

    /**
     * @param License|CoverageStorableInterface $license
     */
    public function setLicense(CoverageStorableInterface $license) { $this->license = $license; }
}