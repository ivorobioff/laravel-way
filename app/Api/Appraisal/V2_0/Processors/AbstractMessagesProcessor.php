<?php
namespace RealEstate\Api\Appraisal\V2_0\Processors;

use RealEstate\Api\Support\BaseProcessor;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
abstract class AbstractMessagesProcessor extends BaseProcessor
{
	/**
	 * @return array
	 */
	protected function configuration()
	{
		return ['content' => 'string'];
	}
}