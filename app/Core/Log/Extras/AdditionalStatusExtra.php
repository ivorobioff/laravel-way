<?php
namespace RealEstate\Core\Log\Extras;

use RealEstate\Core\Customer\Entities\AdditionalStatus;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class AdditionalStatusExtra extends Extra
{
	/**
	 * @param AdditionalStatus $additionalStatus
	 * @return static
	 */
	public static function fromAdditionalStatus(AdditionalStatus $additionalStatus)
	{
		$extra = new static();

		$extra[Extra::TITLE] = $additionalStatus->getTitle();
		$extra[Extra::COMMENT] = $additionalStatus->getComment();

		return $extra;
	}
}