<?php
namespace RealEstate\Core\User\Interfaces;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
interface BusinessInterface
{
    /**
     * @var string $name
     */
    public function setCompanyName($name);

    /**
     * @return string
     */
    public function getCompanyName();
}