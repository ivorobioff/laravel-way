<?php
namespace RealEstate\Core\Company\Persistables;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class FeePersistable
{
    /**
     * @var int
     */
    private $jobType;
    public function setJobType($jobType) { $this->jobType = $jobType; }
    public function getJobType() { return $this->jobType; }

    /**
     * @var float
     */
    private $amount;
    public function setAmount($amount)  { $this->amount = $amount; }
    public function getAmount() { return $this->amount; }
}