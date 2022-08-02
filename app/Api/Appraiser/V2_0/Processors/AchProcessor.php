<?php
namespace RealEstate\Api\Appraiser\V2_0\Processors;

use Restate\Libraries\Validation\Rules\Enum;
use RealEstate\Api\Support\BaseProcessor;
use RealEstate\Core\Appraiser\Enums\AchAccountType;
use RealEstate\Core\Appraiser\Persistables\AchPersistable;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class AchProcessor extends BaseProcessor
{
	/**
	 * @return array
	 */
	protected function configuration()
	{
		return [
			'bankName' => 'string',
			'accountType' => new Enum(AchAccountType::class),
			'accountNumber' => 'string',
			'routing' => 'string'
		];
	}

	/**
	 * @return AchPersistable
	 */
	public function createPersistable()
	{
		return $this->populate(new AchPersistable());
	}
}