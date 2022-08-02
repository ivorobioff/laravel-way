<?php
namespace RealEstate\Core\Customer\Entities;

use RealEstate\Core\Appraisal\Entities\Message as BaseMessage;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class Message extends BaseMessage
{
    /**
     * @var string
     */
    private $employee;
    public function setEmployee($employee) { $this->employee = $employee; }
    public function getEmployee() { return $this->employee; }
}