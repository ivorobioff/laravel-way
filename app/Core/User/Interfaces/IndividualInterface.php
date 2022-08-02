<?php
namespace RealEstate\Core\User\Interfaces;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
interface IndividualInterface
{
    /**
     * @param string $name
     */
    public function setFirstName($name);

    /**
     * @return string
     */
    public function getFirstName();

    /**
     * @var string $name
     */
    public function setLastName($name);

    /**
     * @return string
     */
    public function getLastName();
}