<?php
namespace RealEstate\Core\Shared\Properties;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
trait AdditionalCommentsPropertyTrait
{
	/**
	 * @var string
	 */
	private $additionalComments;

	/**
	 * @param string $comments
	 */
	public function setAdditionalComments($comments)
	{
		$this->additionalComments = $comments;
	}

	/**
	 * @return string
	 */
	public function getAdditionalComments()
	{
		return $this->additionalComments;
	}
}