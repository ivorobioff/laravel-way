<?php
namespace RealEstate\Core\Location\Properties;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
trait ZipPropertyTrait
{
    /**
     * @var string
     */
    private $zip;

	/**
	 * @param string $zip
	 */
	public function setZip($zip)
	{
		$this->zip = $zip;
	}

	/**
	 * @return string
	 */
	public function getZip()
	{
		return $this->zip;
	}
}