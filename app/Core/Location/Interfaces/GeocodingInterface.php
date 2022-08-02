<?php
namespace RealEstate\Core\Location\Interfaces;
use RealEstate\Core\Location\Objects\Coordinates;
use RealEstate\Core\Location\Objects\Location;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
interface GeocodingInterface
{
    /**
     * @param Location $location
     * @return Coordinates
     */
    public function toCoordinates(Location $location);

    /**
     * @param Coordinates $coordinates
     * @return Location
     */
    public function toLocation(Coordinates $coordinates);
}