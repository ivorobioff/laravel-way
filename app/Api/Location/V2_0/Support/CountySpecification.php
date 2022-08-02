<?php
namespace RealEstate\Api\Location\V2_0\Support;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class CountySpecification
{
	public function __invoke($zips)
	{
		$result = [];

		foreach ($zips as $zip){
			$result[] = $zip->getCode();
		}

		return $result;
	}
}