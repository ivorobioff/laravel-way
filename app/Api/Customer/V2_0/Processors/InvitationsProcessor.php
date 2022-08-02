<?php
namespace RealEstate\Api\Customer\V2_0\Processors;

use Restate\Libraries\Validation\Rules\Enum;
use RealEstate\Api\Support\BaseProcessor;
use RealEstate\Core\Invitation\Enums\Requirement;
use RealEstate\Core\Invitation\Persistables\InvitationPersistable;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class InvitationsProcessor extends BaseProcessor
{
	protected function configuration()
	{
		return [
			'ascAppraiser' => 'int',
			'requirements' => [new Enum(Requirement::class)]
		];
	}

	/**
	 * @return InvitationPersistable
	 */
	public function createPersistable()
	{
		return $this->populate(new InvitationPersistable());
	}
}