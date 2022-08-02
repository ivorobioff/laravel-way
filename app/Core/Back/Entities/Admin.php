<?php
namespace RealEstate\Core\Back\Entities;
use RealEstate\Core\User\Entities\User;
use RealEstate\Core\User\Interfaces\EmailHolderInterface;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class Admin extends User implements EmailHolderInterface
{
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


    public function setEmail($email) { $this->email = $email; }
    public function getEmail() { return $this->email; }

    /**
     * @return string
     */
    public function getDisplayName()
    {
        return $this->getFirstName().' '.$this->getLastName();
    }
}