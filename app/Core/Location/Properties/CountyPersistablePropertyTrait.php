<?php
namespace RealEstate\Core\Location\Properties;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
trait CountyPersistablePropertyTrait
{
	/**
	 * @var string
	 */
	private $county;

	/**
	 * @param string $county
	 */
	public function setCounty($county)
	{
		$this->county = $county;
	}

	/**
	 * @return string
	 */
	public function getCounty()
	{
		return $this->county;
	}
}