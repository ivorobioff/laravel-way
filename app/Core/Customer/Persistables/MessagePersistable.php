<?php
namespace RealEstate\Core\Customer\Persistables;

use RealEstate\Core\Appraisal\Persistables\MessagePersistable as BaseMessagePersistable;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class MessagePersistable extends BaseMessagePersistable
{
    /**
     * @var string
     */
    private $employee;
    public function setEmployee($employee) { $this->employee = $employee; }
    public function getEmployee() { return $this->employee; }
}