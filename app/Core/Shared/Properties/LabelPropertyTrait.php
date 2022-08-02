<?php
namespace RealEstate\Core\Shared\Properties;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
trait LabelPropertyTrait
{
	/**
	 * @var string
	 */
	private $label;

	/**
	 * @param string $label
	 */
	public function setLabel($label)
	{
		$this->label = $label;
	}

	/**
	 * @return string
	 */
	public function getLabel()
	{
		return $this->label;
	}
}