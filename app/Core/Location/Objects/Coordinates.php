<?php
namespace RealEstate\Core\Location\Objects;
use RealEstate\Core\Location\Properties\LatitudePropertyTrait;
use RealEstate\Core\Location\Properties\LongitudePropertyTrait;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class Coordinates
{
    use LatitudePropertyTrait;
    use LongitudePropertyTrait;
}