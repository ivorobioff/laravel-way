<?php
namespace RealEstate\Core\Shared\Options;

/**
 *
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
trait TrustedOptionTrait
{
    /**
     * @var bool
     */
    private $isTrusted = false;

    /**
     * @param bool $flag
     * @return $this
     */
    public function setTrusted($flag)
    {
        $this->isTrusted = $flag;
        return $this;
    }

    /**
     * @return bool
     */
    public function isTrusted()
    {
        return $this->isTrusted;
    }
}