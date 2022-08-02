<?php
namespace RealEstate\Core\Shared\Properties;

use DateTime;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
trait UpdatedAtPropertyTrait
{
    /**
     * @var DateTime
     */
    private $updatedAt;

    /**
     * @param DateTime $datetime
     */
    public function setUpdatedAt(DateTime $datetime)
    {
        $this->updatedAt = $datetime;
    }

    /**
     * @return DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
}