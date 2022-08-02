<?php
namespace RealEstate\Core\Location\Properties;

use RealEstate\Core\Location\Entities\State;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
trait StatePropertyTrait
{
    /**
     * @var State
     */
    private $state;

	/**
	 * @param State $state
	 */
	public function setState(State $state = null)
	{
		$this->state = $state;
	}

	/**
	 * @return State
	 */
	public function getState()
	{
		return $this->state;
	}
}