<?php
namespace RealEstate\Core\Document\Properties;

use RealEstate\Core\Document\Enums\Format;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
trait FormatPropertyTrait
{
	/**
	 * @var Format
	 */
	private $format;

	/**
	 * @return Format
	 */
	public function getFormat()
	{
		return $this->format;
	}

	/**
	 * @param Format $format
	 */
	public function setFormat(Format $format)
	{
		$this->format = $format;
	}
}