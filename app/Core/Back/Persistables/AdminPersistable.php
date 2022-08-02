<?php
namespace RealEstate\Core\Back\Persistables;
use RealEstate\Core\User\Persistables\UserPersistable;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class AdminPersistable extends UserPersistable
{
    /**
     * @var string
     */
    private $email;
    public function setEmail($email) { $this->email = $email; }
    public function getEmail() { return $this->email; }
    /**
     * @var string
     */
    private $firstName;
    public function setFirstName($firstName) { $this->firstName = $firstName; }
    public function getFirstName() { return $this->firstName;}

    /**
     * @var string
     */
    private $lastName;
    public function setLastName($lastName) { $this->lastName = $lastName; }
    public function getLastName() { return $this->lastName; }
}