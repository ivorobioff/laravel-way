<?php
namespace RealEstate\Core\Customer\Entities;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class AdditionalDocumentType
{
    /**
     * @var int
     */
    private $id;
    public function setId($id) { $this->id = $id; }
    public function getId() { return $this->id; }

    /**
     * @var string
     */
    private $title;
    public function setTitle($title) { $this->title = $title; }
    public function getTitle() { return $this->title; }

	/**
	 * @var Customer
	 */
	private $customer;
	public function setCustomer(Customer $customer) { $this->customer = $customer; }
}