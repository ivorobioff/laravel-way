<?php
namespace RealEstate\Core\Shared\Properties;

/**
 *
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
trait IdPropertyTrait
{
    /**
     * @var int
     */
    private $id;

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}