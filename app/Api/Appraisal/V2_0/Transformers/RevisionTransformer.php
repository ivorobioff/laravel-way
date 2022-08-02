<?php
namespace RealEstate\Api\Appraisal\V2_0\Transformers;

use RealEstate\Api\Support\BaseTransformer;
use RealEstate\Core\Appraisal\Entities\Revision;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class RevisionTransformer extends BaseTransformer
{
	/**
	 * @param Revision $revision
	 * @return array
	 */
	public function transform($revision)
	{
		return $this->extract($revision);
	}
}