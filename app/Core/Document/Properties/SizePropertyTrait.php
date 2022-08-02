<?php
namespace RealEstate\Core\Document\Properties;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
trait SizePropertyTrait
{
	/**
	 * @var int
	 */
	private $size;

	/**
	 * @return int
	 */
	public function getSize()
	{
		return $this->size;
	}

	/**
	 * @param int $size
	 */
	public function setSize($size)
	{
		$this->size = $size;
	}
}