<?php
namespace RealEstate\Core\Assignee\Persistables;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class NotificationSubscriptionPersistable
{
	/**
	 * @var bool
	 */
	private $email;
	public function getEmail() { return $this->email; }
	public function setEmail($email) { $this->email = $email; }}