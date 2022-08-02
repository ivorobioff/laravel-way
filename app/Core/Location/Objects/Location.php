<?php
namespace RealEstate\Core\Location\Objects;
use RealEstate\Core\Location\Properties\Address1PropertyTrait;
use RealEstate\Core\Location\Properties\Address2PropertyTrait;
use RealEstate\Core\Location\Properties\CityPropertyTrait;
use RealEstate\Core\Location\Properties\StateAsCodePropertyTrait;
use RealEstate\Core\Location\Properties\ZipPropertyTrait;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class Location
{
    use Address1PropertyTrait;
    use Address2PropertyTrait;
    use CityPropertyTrait;
    use StateAsCodePropertyTrait;
    use ZipPropertyTrait;

    public function __toString()
    {
        return $this->getAddress1().', '.$this->getCity().', '.$this->getState().' '.$this->getZip();
    }
}