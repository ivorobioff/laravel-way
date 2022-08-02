<?php
namespace RealEstate\Core\Customer\Persistables;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class AdditionalStatusPersistable
{
    /**
     * @var string
     */
    private $title;
    public function setTitle($title) { $this->title = $title; }
    public function getTitle() { return $this->title; }

    /**
     * @var string
     */
    private $comment;
    public function setComment($comment) { $this->comment = $comment; }
    public function getComment() { return $this->comment; }
}