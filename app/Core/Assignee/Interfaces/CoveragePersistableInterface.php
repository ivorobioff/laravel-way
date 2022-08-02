<?php
namespace RealEstate\Core\Assignee\Interfaces;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
interface CoveragePersistableInterface
{
    /**
     * @param int $county
     */
    public function setCounty($county);

    /**
     * @return int
     */
    public function getCounty();

    /**
     * @param array $zips
     */
    public function setZips(array $zips);

    /**
     * @return array $zips
     */
    public function getZips();
}