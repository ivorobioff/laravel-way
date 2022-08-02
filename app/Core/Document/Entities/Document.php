<?php
namespace RealEstate\Core\Document\Entities;

use DateTime;
use RealEstate\Core\Document\Properties\FormatPropertyTrait;
use RealEstate\Core\Document\Properties\SizePropertyTrait;
use RealEstate\Core\Document\Properties\TokenPropertyTrait;
use RealEstate\Core\Shared\Properties\IdPropertyTrait;
use RealEstate\Core\Shared\Properties\NamePropertyTrait;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class Document
{
    use IdPropertyTrait;
	use NamePropertyTrait;
	use TokenPropertyTrait;
	use SizePropertyTrait;
	use FormatPropertyTrait;

	/**
	 * @var string
	 */
	private $uri;

    /**
     * @var int
     */
    private $usage = 0;

    /**
     * @var DateTime
     */
    private $uploadedAt;

	/**
	 * @var bool
	 */
	private $isExternal = false;

	/**
	 * @return string
	 */
	public function getUri()
	{
		return $this->uri;
	}

	/**
	 * @param string $uri
	 */
	public function setUri($uri)
	{
		$this->uri = $uri;
	}

    /**
     * @param DateTime $uploadedAt
     */
    public function setUploadedAt(DateTime $uploadedAt)
    {
        $this->uploadedAt = $uploadedAt;
    }

    /**
     * @return DateTime
     */
    public function getUploadedAt()
    {
        return $this->uploadedAt;
    }

    public function increaseUsage()
    {
        $this->usage ++;
    }

    public function decreaseUsage()
    {
        $this->usage --;
    }

	/**
	 * @param bool $flag
	 */
	public function setExternal($flag)
	{
		$this->isExternal = $flag;
	}

	/**
	 * @return bool
	 */
	public function isExternal()
	{
		return $this->isExternal;
	}
} 