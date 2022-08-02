<?php
namespace RealEstate\Core\Appraiser\Options;

use RealEstate\Core\Shared\Options\UpdateOptions;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class UpdateAppraiserOptions extends UpdateOptions
{
	/**
	 * @var bool
	 */
	private $isSoftValidationMode = false;

	/**
	 * @param bool $flag
	 */
	public function setSoftValidationMode($flag)
	{
		$this->isSoftValidationMode = $flag;
	}

	/**
	 * @return bool
	 */
	public function isSoftValidationMode()
	{
		return $this->isSoftValidationMode;
	}
}