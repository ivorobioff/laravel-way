<?php
namespace RealEstate\Core\Document\Persistables;

use RealEstate\Core\Document\Properties\FormatPropertyTrait;
use RealEstate\Core\Document\Properties\SizePropertyTrait;
use RealEstate\Core\Shared\Properties\NamePropertyTrait;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class ExternalDocumentPersistable
{
	use NamePropertyTrait;
	use FormatPropertyTrait;
	use SizePropertyTrait;

	/**
	 * @var string
	 */
	private $url;

	/**
	 * @param string $url
	 */
	public function setUrl($url)
	{
		$this->url = $url;
	}

	/**
	 * @return string
	 */
	public function getUrl()
	{
		return $this->url;
	}
}