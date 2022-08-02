<?php
namespace RealEstate\Api\Customer\V2_0\Transformers;

use RealEstate\Api\Support\BaseTransformer;
use RealEstate\Core\Customer\Entities\DocumentSupportedFormats;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class DocumentSupportedFormatsTransformer extends BaseTransformer
{
	/**
	 * @param DocumentSupportedFormats $formats
	 * @return array
	 */
	public function transform($formats)
	{
		return $this->extract($formats);
	}
}
