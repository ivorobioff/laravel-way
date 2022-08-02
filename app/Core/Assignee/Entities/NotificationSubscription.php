<?php
namespace RealEstate\Core\Assignee\Entities;

use RealEstate\Core\Appraiser\Entities\Appraiser;
use RealEstate\Core\Customer\Entities\Customer;
use RealEstate\Core\User\Entities\User;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class NotificationSubscription
{
	/**
	 * @var int
	 */
	private $id;
	public function setId($id) { $this->id = $id; }
	public function getId() { return $this->id; }

	/**
	 * @var Appraiser
	 */
	private $assignee;
	public function setAssignee(User $assignee) { $this->assignee = $assignee; }
	public function getAssignee() { return $this->assignee; }


	/**
	 * @var Customer
	 */
	private $customer;
	public function setCustomer(Customer $customer) { $this->customer = $customer; }
	public function getCustomer() { return $this->customer; }

	/**
	 * @var bool
	 */
	private $email;
	public function getEmail() { return $this->email; }
	public function setEmail($email) { $this->email = $email; }


	public function __construct()
	{
		$this->setEmail(true);
	}
}