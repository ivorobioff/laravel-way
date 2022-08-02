<?php
namespace RealEstate\Api\Customer\V2_0\Processors;

use Restate\Libraries\Validation\Rules\Enum;
use RealEstate\Api\Support\BaseProcessor;
use RealEstate\Core\Customer\Enums\ExtraFormat;
use RealEstate\Core\Customer\Enums\Format;
use RealEstate\Core\Customer\Persistables\DocumentSupportedFormatsPersistable;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class DocumentFormatsProcessor extends BaseProcessor
{
	protected function configuration()
	{
		return [
			'jobType' => 'int',
			'primary' => [new Enum(Format::class)],
			'extra' => [new Enum(ExtraFormat::class)]
		];
	}

	/**
	 * @return DocumentSupportedFormatsPersistable
	 */
	public function createPersistable()
	{
		return $this->populate(new DocumentSupportedFormatsPersistable());
	}
}