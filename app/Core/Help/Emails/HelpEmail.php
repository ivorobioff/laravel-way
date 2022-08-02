<?php
namespace RealEstate\Core\Help\Emails;

use RealEstate\Core\Support\Letter\Email;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
abstract class HelpEmail extends Email
{
	/**
	 * @var string
	 */
	private $description;

	/**
	 * @param string $description
	 */
	public function __construct($description)
	{
		$this->description = $description;
	}

	/**
	 * @return string
	 */
	public function getDescription()
	{
		return $this->description;
	}
}