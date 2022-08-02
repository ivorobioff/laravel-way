<?php
namespace RealEstate\Core\Shared\Interfaces;

/**
 *
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
interface TokenGeneratorInterface
{
    /**
     * @return string
     */
    public function generate();
}