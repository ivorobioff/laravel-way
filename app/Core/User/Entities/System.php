<?php
namespace RealEstate\Core\User\Entities;
use RealEstate\Core\User\Interfaces\EmailHolderInterface;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class System extends User implements EmailHolderInterface
{
    /**
     * @var string
     */
    private $name;
    public function setName($name) { $this->name = $name; }
    public function getName() { return $this->name; }

    public function setEmail($email) { $this->email = $email; }
    public function getEmail() { return $this->email; }

    public function getDisplayName() { return $this->getName(); }
}