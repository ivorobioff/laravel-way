<?php
namespace RealEstate\Api\Customer\V2_0\Transformers;

use RealEstate\Api\Support\BaseTransformer;
use RealEstate\Core\Customer\Entities\AdditionalDocumentType;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class AdditionalDocumentTypeTransformer extends BaseTransformer
{
	/**
	 * @param AdditionalDocumentType $type
	 * @return array
	 */
	public function transform($type)
	{
		return $this->extract($type);
	}
}