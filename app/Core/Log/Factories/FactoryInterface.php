<?php
namespace RealEstate\Core\Log\Factories;

use RealEstate\Core\Log\Entities\Log;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
interface FactoryInterface
{
	/**
	 * @param object $notification
	 * @return Log
	 */
	public function create($notification);
}