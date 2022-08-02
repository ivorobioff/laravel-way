<?php
namespace RealEstate\Core\Location\Properties;

/**
 *
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
trait StateAsCodePropertyTrait
{
    /**
     * @var string
     */
    private $state;

    /**
     * @param string $state
     */
    public function setState($state)
    {
        $this->state = $state;
    }

    /**
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }
}