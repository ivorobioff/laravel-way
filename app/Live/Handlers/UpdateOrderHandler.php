<?php
namespace RealEstate\Live\Handlers;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class UpdateOrderHandler extends AbstractDataAwareOrderHandler
{
	/**
	 * @return string
	 */
	protected function getName()
	{
		return 'update';
	}
}