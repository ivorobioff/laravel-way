<?php
namespace RealEstate\Core\Location\Properties;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
trait LongitudePropertyTrait
{
    /**
     * @var string
     */
    private $longitude;

    /**
     * @param string $longitude
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
    }

    /**
     * @return string
     */
    public function getLongitude()
    {
        return $this->longitude;
    }
}