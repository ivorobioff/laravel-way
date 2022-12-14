<?php
namespace RealEstate\Core\Customer\Entities;

use RealEstate\Core\Customer\Enums\Formats;
use RealEstate\Core\Customer\Enums\ExtraFormats;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class DocumentSupportedFormats
{
    /**
     * @var int
     */
    private $id;
    public function setId($id) { $this->id = $id; }
    public function getId() { return $this->id; }

    /**
     * @var Formats
     */
    private $primary;
    public function setPrimary(Formats $formats) { $this->primary = $formats; }
    public function getPrimary() { return $this->primary; }


    /**
     * @var ExtraFormats
     */
    private $extra;
    public function setExtra(ExtraFormats $formats = null) { $this->extra = $formats; }
    public function getExtra() { return $this->extra; }

    /**
     * @var JobType
     */
    private $jobType;
    public function setJobType(JobType $jobType) { $this->jobType = $jobType; }
    public function getJobType() { return $this->jobType; }

    /**
     * @var Customer
     */
    private $customer;
    public function setCustomer(Customer $customer) { $this->customer = $customer; }
    public function getCustomer() { return $this->customer; }
}