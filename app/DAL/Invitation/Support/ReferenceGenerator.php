<?php
namespace RealEstate\DAL\Invitation\Support;

use RealEstate\Core\Invitation\Interfaces\ReferenceGeneratorInterface;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class ReferenceGenerator implements ReferenceGeneratorInterface
{
	/**
	 * @return string
	 */
	public function generate()
	{
		return str_random(64);
	}
}