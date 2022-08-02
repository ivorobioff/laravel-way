<?php
namespace RealEstate\Core\Location\Properties;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
trait LatitudePropertyTrait
{
    /**
     * @var string
     */
    private $latitude;

    /**
     * @param string $latitude
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
    }

    /**
     * @return string
     */
    public function getLatitude()
    {
        return $this->latitude;
    }
}