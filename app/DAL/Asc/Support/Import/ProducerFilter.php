<?php
namespace RealEstate\DAL\Asc\Support\Import;

use FilterIterator;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class ProducerFilter extends FilterIterator
{
	public function accept()
	{
		/**
		 * @var Producer $producer
		 */
		$producer = $this->getInnerIterator();

		return $producer->isActive();
	}
}