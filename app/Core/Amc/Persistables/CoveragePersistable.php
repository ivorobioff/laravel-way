<?php
namespace RealEstate\Core\Amc\Persistables;
use RealEstate\Core\Assignee\Interfaces\CoveragePersistableInterface;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class CoveragePersistable implements CoveragePersistableInterface
{
    /**
     * @var int
     */
    private $county;
    public function setCounty($county) { $this->county = $county; }
    public function getCounty() { return $this->county; }

    /**
     * @var array
     */
    private $zips;
    public function setZips(array $zips) { $this->zips = $zips; }
    public function getZips() { return $this->zips; }
}