<?php
namespace RealEstate\Core\Assignee\Objects;

use RealEstate\Core\Customer\Entities\Customer;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class Total
{
    /**
     * @var Customer
     */
    private $customer;
    public function setCustomer(Customer $customer) { $this->customer = $customer; }
    public function getCustomer() { return $this->customer; }

    /**
     * @var bool
     */
    private $enabled;
    public function setEnabled($number) { $this->enabled = $number; }
    public function getEnabled() { return $this->enabled; }
}
