<?php
namespace RealEstate\Core\Log\Entities;

use RealEstate\Core\Amc\Entities\Amc;
use RealEstate\Core\Appraisal\Entities\Order;
use RealEstate\Core\Appraiser\Entities\Appraiser;
use RealEstate\Core\Customer\Entities\Customer;
use RealEstate\Core\Log\Enums\Action;
use RealEstate\Core\Log\Extras\EmptyExtra;
use RealEstate\Core\Log\Extras\ExtraInterface;
use RealEstate\Core\User\Entities\User;
use DateTime;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class Log
{
	/**
	 * @var int
	 */
	private $id;
	public function setId($id) { $this->id = $id; }
	public function getId() { return $this->id; }

	/**
	 * @var Order
	 */
	private $order;
	public function setOrder(Order $order = null) { $this->order = $order; }
	public function getOrder() { return $this->order; }

    /**
     * @var Customer
     */
	private $customer;
    public function setCustomer(Customer $customer) { $this->customer = $customer; }
    public function getCustomer() { return $this->customer; }

	/**
	 * @var Appraiser|Amc
	 */
	private $assignee;
	public function setAssignee(User $assignee) { $this->assignee = $assignee; }
	public function getAssignee() { return $this->assignee; }

	/**
	 * @var DateTime
	 */
	private $createdAt;
	public function setCreatedAt(DateTime $datetime) { $this->createdAt = $datetime; }
	public function getCreatedAt() { return $this->createdAt; }

	/**
	 * @var User
	 */
	private $user;
	public function setUser(User $user) { $this->user = $user; }
	public function getUser() { return $this->user; }

	/**
	 * @var ExtraInterface
	 */
	private $extra;
	public function getExtra() { return $this->extra; }
	public function setExtra(ExtraInterface $extra) { $this->extra = $extra; }

	/**
	 * @var Action
	 */
	private $action;
	public function setAction(Action $action) { $this->action = $action; }
	public function getAction() { return $this->action; }

	public function __construct()
	{
		$this->extra = new EmptyExtra();
	}
}