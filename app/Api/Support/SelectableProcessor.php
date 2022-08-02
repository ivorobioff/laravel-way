<?php
namespace RealEstate\Api\Support;

use Restate\Libraries\Processor\AbstractProcessor;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class SelectableProcessor extends AbstractProcessor
{
	/**
	 * @return array
	 */
	public function getIds()
	{
		$ids = explode(',', $this->getRequest()->input('ids', ''));
		$ids = array_filter($ids, function($v){
			return is_numeric($v);
		});

		return array_map(function($v){ return (int) $v;}, $ids);
	}
}