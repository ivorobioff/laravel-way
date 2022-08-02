<?php
namespace RealEstate\Core\Assignee\Interfaces;
use RealEstate\Core\Location\Entities\County;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
interface CoverageInterface
{
    /**
     * @param County $county
     */
    public function setCounty(County $county);

    /**
     * @return County
     */
    public function getCounty();

    /**
     * @param string $zip
     */
    public function setZip($zip);

    /**
     * @return string
     */
    public function getZip();

    /**
     * @param CoverageStorableInterface $license
     */
    public function setLicense(CoverageStorableInterface $license);
}