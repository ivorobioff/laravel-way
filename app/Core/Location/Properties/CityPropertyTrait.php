<?php
namespace RealEstate\Core\Location\Properties;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
trait CityPropertyTrait
{
    /**
     * @var string
     */
    private $city;

	/**
	 * @param string $city
	 */
	public function setCity($city)
	{
		$this->city = $city;
	}

	/**
	 * @return string
	 */
	public function getCity()
	{
		return $this->city;
	}
}