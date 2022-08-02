<?php
namespace RealEstate\Core\Appraisal\Notifications;

use RealEstate\Core\Appraisal\Entities\Order;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
abstract class AbstractNotification
{
	/**
	 * @var Order
	 */
	private $order;

	/**
	 * @param Order $order
	 */
	public function __construct(Order $order)
	{
		$this->order = $order;
	}

	/**
	 * @return Order
	 */
	public function getOrder()
	{
		return $this->order;
	}
}