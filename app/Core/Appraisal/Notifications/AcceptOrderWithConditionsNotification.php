<?php
namespace RealEstate\Core\Appraisal\Notifications;

use RealEstate\Core\Appraisal\Entities\Order;
use RealEstate\Core\Appraisal\Objects\Conditions;


/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class AcceptOrderWithConditionsNotification extends AbstractNotification
{
	/**
	 * @var Conditions
	 */
	private $conditions;

	public function __construct(Order $order, Conditions $conditions)
	{
		parent::__construct($order);

		$this->conditions = $conditions;
	}

	/**
	 * @return Conditions
	 */
	public function getConditions()
	{
		return $this->conditions;
	}
}