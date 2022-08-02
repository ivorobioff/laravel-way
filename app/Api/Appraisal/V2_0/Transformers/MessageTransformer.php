<?php
namespace RealEstate\Api\Appraisal\V2_0\Transformers;

use RealEstate\Api\Support\BaseTransformer;
use RealEstate\Core\Appraisal\Entities\Message;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class MessageTransformer extends BaseTransformer
{
	/**
	 * @param Message $message
	 * @return array
	 */
	public function transform($message)
	{
		return $this->extract($message);
	}
}