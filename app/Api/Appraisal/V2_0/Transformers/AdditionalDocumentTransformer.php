<?php
namespace RealEstate\Api\Appraisal\V2_0\Transformers;

use RealEstate\Api\Support\BaseTransformer;
use RealEstate\Core\Appraisal\Entities\AdditionalDocument;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class AdditionalDocumentTransformer extends BaseTransformer
{
	/**
	 * @param AdditionalDocument $document
	 * @return array
	 */
	public function transform($document)
	{
		return $this->extract($document);
	}
}