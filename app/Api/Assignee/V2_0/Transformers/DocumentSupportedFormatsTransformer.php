<?php
namespace RealEstate\Api\Assignee\V2_0\Transformers;

use RealEstate\Api\Support\BaseTransformer;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class DocumentSupportedFormatsTransformer extends BaseTransformer
{
	/**
	 * @param object $item
	 * @return array
	 */
	public function transform($item)
	{
		return $this->extract($item);
	}
}