<?php
namespace RealEstate\Core\Company\Entities;
use RealEstate\Core\JobType\Entities\JobType;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class Fee
{
    private $id;
    public function setId($id) { $this->id = $id; }
    public function getId() { return $this->id; }

    /**
     * @var JobType
     */
    private $jobType;
    public function setJobType(JobType $jobType) { $this->jobType = $jobType; }
    public function getJobType() { return $this->jobType; }

    /**
     * @var float
     */
    private $amount;
    public function setAmount($amount) { $this->amount = $amount; }
    public function getAmount() { return $this->amount; }

    /**
     * @var Company
     */
    private $company;
    public function setCompany(Company $company) { $this->company = $company; }
    public function getCompany() { return $this->company; }
}