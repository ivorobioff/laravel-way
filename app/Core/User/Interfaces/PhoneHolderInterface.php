<?php
namespace RealEstate\Core\User\Interfaces;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
interface PhoneHolderInterface
{
    /**
     * @var string $phone
     */
    public function setPhone($phone);

    /**
     * @return string
     */
    public function getPhone();
}