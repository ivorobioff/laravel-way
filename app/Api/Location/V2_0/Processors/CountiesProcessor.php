<?php
namespace RealEstate\Api\Location\V2_0\Processors;

use Restate\Libraries\Processor\AbstractProcessor;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class CountiesProcessor extends AbstractProcessor
{
	/**
	 * Indicates whether auto validation is allowed
	 *
	 * @return bool
	 */
	public function validateAutomatically()
	{
		return false;
	}

	/**
	 * @return array
	 */
	public function getSelectedCounties()
	{
		return $this->get('filter.counties', '', 'explode');
	}
}