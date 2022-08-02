<?php
namespace RealEstate\Core\Location\Entities;

use Doctrine\Common\Collections\ArrayCollection;
use RealEstate\Core\Location\Properties\StatePropertyTrait;
use RealEstate\Core\Shared\Properties\IdPropertyTrait;
use RealEstate\Core\Shared\Properties\TitlePropertyTrait;

/**
 *
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class County
{
    use IdPropertyTrait;
	use TitlePropertyTrait;
    use StatePropertyTrait;

	/**
	 * @var Zip[]
	 */
	private $zips;

	public function __construct()
	{
		$this->zips = new ArrayCollection();
	}

	/**
	 * @return ArrayCollection|Zip[]
	 */
	public function getZips()
	{
		return $this->zips;
	}

	/**
	 * @param Zip $zip
	 */
	public function addZip(Zip $zip)
	{
		$this->zips->add($zip);
	}
}