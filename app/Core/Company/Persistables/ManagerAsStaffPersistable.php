<?php
namespace RealEstate\Core\Company\Persistables;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class ManagerAsStaffPersistable extends StaffPersistable
{
    /**
     * @var ManagerPersistable
     */
    private $user;
    public function setUser(ManagerPersistable $persistable) { $this->user = $persistable; }
    public function getUser() { return $this->user; }
}