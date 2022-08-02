<?php
namespace RealEstate\DAL\Shared\Support;

use RealEstate\Core\Shared\Interfaces\TokenGeneratorInterface;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class TokenGenerator implements TokenGeneratorInterface
{
    /**
     * @return string
     */
    public function generate()
    {
        return str_random(64);
    }
}