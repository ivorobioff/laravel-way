<?php
namespace RealEstate\Api\Customer\V2_0\Processors;

use Restate\Libraries\Validation\Rules\Enum;
use RealEstate\Api\Support\BaseProcessor;
use RealEstate\Core\Customer\Enums\Criticality;
use RealEstate\Core\Customer\Persistables\SettingsPersistable;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class SettingsProcessor extends BaseProcessor
{
	protected function configuration()
	{
		return [
			'pushUrl' => 'string',
			'daysPriorInspectionDate' => 'int',
			'daysPriorEstimatedCompletionDate' => 'int',
			'preventViolationOfDateRestrictions' => new Enum(Criticality::class),
			'disallowChangeJobTypeFees' => 'bool',
			'showClientToAppraiser' => 'bool',
			'showDocumentsToAppraiser' => 'bool',
			'isSmsEnabled' => 'bool',
            'unacceptedReminder' => 'int'
		];
	}

	/**
	 * @return SettingsPersistable
	 */
	public function createPersistable()
	{
		return $this->populate(new SettingsPersistable());
	}
}