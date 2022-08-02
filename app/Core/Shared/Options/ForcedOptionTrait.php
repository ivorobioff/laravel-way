<?php
namespace RealEstate\Core\Shared\Options;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
trait ForcedOptionTrait
{
	/**
	 * @var bool
	 */
	private $isForced = false;

	/**
	 * @param bool $flag
	 */
	public function setForced($flag)
	{
		$this->isForced = $flag;
	}

	/**
	 * @return bool
	 */
	public function isForced()
	{
		return $this->isForced;
	}
}