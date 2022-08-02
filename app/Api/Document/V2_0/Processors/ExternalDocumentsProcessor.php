<?php
namespace RealEstate\Api\Document\V2_0\Processors;

use Restate\Libraries\Validation\Rules\Enum;
use RealEstate\Api\Support\BaseProcessor;
use RealEstate\Core\Document\Enums\Format;
use RealEstate\Core\Document\Persistables\ExternalDocumentPersistable;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class ExternalDocumentsProcessor extends BaseProcessor
{
	/**
	 * @return array
	 */
	protected function configuration()
	{
		return [
			'name' => 'string',
			'size' => 'int',
			'format' => new Enum(Format::class),
			'url' => 'string'
		];
	}

	/**
	 * @return ExternalDocumentPersistable
	 */
	public function createPersistable()
	{
		return $this->populate(new ExternalDocumentPersistable());
	}
}