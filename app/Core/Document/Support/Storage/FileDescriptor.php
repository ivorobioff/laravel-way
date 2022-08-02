<?php
namespace RealEstate\Core\Document\Support\Storage;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class FileDescriptor
{
    /**
     * @var int
     */
    private $size;

    /**
     * @param int $size
     */
    public function setSize($size)
    {
        $this->size = $size;
    }

    /**
     * @return int
     */
    public function getSize()
    {
        return $this->size;
    }
}