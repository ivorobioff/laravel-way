<?php
namespace RealEstate\Core\Appraiser\Notifications;
use RealEstate\Core\Appraiser\Entities\Ach;
use RealEstate\Core\Appraiser\Entities\Appraiser;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class UpdateAchNotification extends AbstractAppraiserNotification
{
    /**
     * @var Ach
     */
    private $ach;

    /**
     * @param Ach $ach
     * @param Appraiser $appraiser
     */
    public function __construct(Ach $ach, Appraiser $appraiser)
    {
        parent::__construct($appraiser);
        $this->ach = $ach;
    }

    /**
     * @return Ach
     */
    public function getAch()
    {
        return $this->ach;
    }
}