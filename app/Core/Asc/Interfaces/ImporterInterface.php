<?php
namespace RealEstate\Core\Asc\Interfaces;

use RealEstate\Core\Asc\Persistables\AppraiserPersistable;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
interface ImporterInterface
{
	/**
	 * @return AppraiserPersistable[]
	 */
	public function import();
}