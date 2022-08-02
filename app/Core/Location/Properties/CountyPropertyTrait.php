<?php
namespace RealEstate\Core\Location\Properties;

use RealEstate\Core\Location\Entities\County;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
trait CountyPropertyTrait
{
	/**
	 * @var County
	 */
	private $county;

	/**
	 * @param County $county
	 */
	public function setCounty(County $county)
	{
		$this->county = $county;
	}

	/**
	 * @return County
	 */
	public function getCounty()
	{
		return $this->county;
	}
}