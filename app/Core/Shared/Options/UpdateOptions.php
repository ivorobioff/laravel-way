<?php
namespace RealEstate\Core\Shared\Options;

/**
 *
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class UpdateOptions
{
    /**
     * @var array
     */
    private $propertiesScheduledToClear = [];

    /**
     * @param array $properties
     * @return $this
     */
    public function schedulePropertiesToClear(array $properties)
    {
        $this->propertiesScheduledToClear = $properties;
        return $this;
    }

	/**
	 * @param string $property
	 * @return bool
	 */
	public function isPropertyScheduledToClear($property)
	{
		return in_array($property, $this->propertiesScheduledToClear);
	}

	/**
	 * @return array
	 */
    public function getPropertiesScheduledToClear()
    {
        return $this->propertiesScheduledToClear;
    }
}