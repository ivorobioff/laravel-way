<?php
namespace RealEstate\Api\Invitation\V2_0\Transformers;

use RealEstate\Api\Support\BaseTransformer;
use RealEstate\Core\Invitation\Entities\Invitation;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class InvitationTransformer extends BaseTransformer
{
	/**
	 * @param Invitation $invitation
	 * @return array
	 */
	public function transform($invitation)
	{
		return $this->extract($invitation);
	}
}