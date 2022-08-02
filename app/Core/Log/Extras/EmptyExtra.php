<?php
namespace RealEstate\Core\Log\Extras;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class EmptyExtra implements ExtraInterface
{
	/**
	 * @param array $data
	 */
	public function setData(array $data)
	{
		//
	}

	/**
	 * @return array
	 */
	public function getData()
	{
		return [];
	}
}