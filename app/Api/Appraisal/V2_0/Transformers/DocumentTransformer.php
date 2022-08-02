<?php
namespace RealEstate\Api\Appraisal\V2_0\Transformers;

use RealEstate\Api\Support\BaseTransformer;
use RealEstate\Core\Appraisal\Entities\Document;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class DocumentTransformer extends BaseTransformer
{
	/**
	 * @param Document $document
	 * @return array
	 */
	public function transform($document)
	{
		return $this->extract($document);
	}
}