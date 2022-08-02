<?php
namespace RealEstate\Core\Appraiser\Notifications;
use RealEstate\Core\Appraiser\Entities\Appraiser;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
abstract class AbstractAppraiserNotification
{
    /**
     * @var Appraiser
     */
    private $appraiser;

    /**
     * @param Appraiser $appraiser
     */
    public function __construct(Appraiser $appraiser)
    {
        $this->appraiser = $appraiser;
    }

    /**
     * @return Appraiser
     */
    public function getAppraiser()
    {
        return $this->appraiser;
    }
}