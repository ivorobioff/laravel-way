<?php
namespace RealEstate\Core\Shared\Properties;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
trait TitlePropertyTrait
{
	/**
	 * @var string
	 */
	private $title;

	/**
	 * @param string $title
	 */
	public function setTitle($title)
	{
		$this->title = $title;
	}

	/**
	 * @return string
	 */
	public function getTitle()
	{
		return $this->title;
	}
}