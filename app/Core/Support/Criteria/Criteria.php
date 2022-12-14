<?php
namespace RealEstate\Core\Support\Criteria;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class Criteria
{
	const EQUAL = 'equal';
	const SIMILAR = 'similar';
	const BETWEEN = 'between';

	/**
	 * @var string
	 */
	private $property;

	/**
	 * @var mixed
	 */
	private $value;

	/**
	 * @var Constraint
	 */
	private $constraint;

	/**
	 * @param string $property
	 * @param Constraint $constraint
	 * @param mixed $value
	 */
	public function __construct($property, Constraint $constraint, $value)
	{
		$this->property = $property;
		$this->constraint = $constraint;
		$this->value = $value;
	}

	/**
	 * @return string
	 */
	public function getProperty()
	{
		return $this->property;
	}

	/**
	 * @return Constraint
	 */
	public function getConstraint()
	{
		return $this->constraint;
	}

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }
}