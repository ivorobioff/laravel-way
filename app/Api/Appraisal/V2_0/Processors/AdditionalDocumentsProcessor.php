<?php
namespace RealEstate\Api\Appraisal\V2_0\Processors;

use RealEstate\Api\Appraisal\V2_0\Support\AdditionalDocumentsConfigurationTrait;
use RealEstate\Api\Support\BaseProcessor;
use RealEstate\Core\Appraisal\Persistables\AdditionalDocumentPersistable;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class AdditionalDocumentsProcessor extends BaseProcessor
{
	use AdditionalDocumentsConfigurationTrait;

	/**
	 * @return array
	 */
	protected function configuration()
	{
		return $this->getAdditionalDocumentsConfiguration();
	}

	/**
	 * @return AdditionalDocumentPersistable
	 */
	public function createPersistable()
	{
		return $this->populate(new AdditionalDocumentPersistable());
	}
}