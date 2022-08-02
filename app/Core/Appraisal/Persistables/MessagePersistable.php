<?php
namespace RealEstate\Core\Appraisal\Persistables;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class MessagePersistable
{
	/**
	 * @var string
	 */
	private $content;
	public function setContent($content) { $this->content = $content; }
	public function getContent() { return $this->content; }
}