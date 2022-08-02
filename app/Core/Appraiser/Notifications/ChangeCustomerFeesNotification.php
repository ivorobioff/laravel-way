<?php
namespace RealEstate\Core\Appraiser\Notifications;
use RealEstate\Core\Appraiser\Entities\Appraiser;
use RealEstate\Core\Customer\Entities\Customer;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class ChangeCustomerFeesNotification extends AbstractAppraiserNotification
{
    /**
     * @var Customer
     */
    private $customer;

    /**
     * @param Appraiser $appraiser
     * @param Customer $customer
     */
    public function __construct(Appraiser $appraiser, Customer $customer)
    {
        parent::__construct($appraiser);
        $this->customer = $customer;
    }

    /**
     * @return Customer
     */
    public function getCustomer()
    {
        return $this->customer;
    }
}