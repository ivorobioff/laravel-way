<?php
namespace RealEstate\Core\User\Interfaces;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
interface FaxHolderInterface
{
    /**
     * @var string $fax
     */
    public function setFax($fax);

    /**
     * @return string
     */
    public function getFax();
}