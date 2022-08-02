<?php
namespace RealEstate\Live\Handlers;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class DeleteOrderHandler extends AbstractDataAwareOrderHandler
{
	/**
	 * @return string
	 */
	protected function getName()
	{
		return 'delete';
	}
}