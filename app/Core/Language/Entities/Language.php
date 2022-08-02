<?php
namespace RealEstate\Core\Language\Entities;

use RealEstate\Core\Shared\Properties\NamePropertyTrait;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class Language
{
	use NamePropertyTrait;

    /**
     * @var string
     */
    private $code;

    /**
     * @param string $code
     */
    public function setCode($code)
    {
        $this->code = $code;
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }
}