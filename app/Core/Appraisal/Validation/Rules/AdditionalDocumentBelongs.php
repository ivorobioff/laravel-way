<?php
namespace RealEstate\Core\Appraisal\Validation\Rules;

use Restate\Libraries\Validation\Error;
use Restate\Libraries\Validation\Rules\AbstractRule;
use Restate\Libraries\Validation\Value;
use RealEstate\Core\Appraisal\Entities\Order;
use RealEstate\Core\Appraisal\Services\OrderService;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class AdditionalDocumentBelongs extends AbstractRule
{
	/**
	 * @var OrderService
	 */
	private $orderService;

	/**
	 * @var Order
	 */
	private $order;

	/**
	 * @param OrderService $orderService
	 * @param Order $order
	 */
	public function __construct(OrderService $orderService, Order $order)
	{
		$this->orderService = $orderService;
		$this->order = $order;

		$this->setIdentifier('not-belong');
		$this->setMessage('The provided additional document does not belong to the specified order.');
	}

	/**
	 * @param mixed|Value $value
	 * @return Error|null
	 */
	public function check($value)
	{
		if ($value == object_take($this->order, 'contractDocument.id')){
			return null;
		}

		if (!$this->orderService->hasAdditionalDocument($this->order->getId(), $value)){
			return $this->getError();
		}

		return null;
	}
}