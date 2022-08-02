<?php
namespace RealEstate\Live\Handlers;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class BidRequestHandler extends AbstractDataAwareOrderHandler
{
	/**
	 * @return string
	 */
	protected function getName()
	{
		return 'bid-request';
	}
}