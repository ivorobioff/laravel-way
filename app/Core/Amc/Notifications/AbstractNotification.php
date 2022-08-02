<?php
namespace RealEstate\Core\Amc\Notifications;
use RealEstate\Core\Amc\Entities\Amc;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
abstract class AbstractNotification
{
    /**
     * @var Amc
     */
    private $amc;

    /**
     * @param Amc $amc
     */
    public function __construct(Amc $amc)
    {
        $this->amc = $amc;
    }

    /**
     * @return Amc
     */
    public function getAmc()
    {
        return $this->amc;
    }
}