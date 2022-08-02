<?php
namespace RealEstate\Core\Log\Factories;
use RealEstate\Core\Appraisal\Notifications\AwardOrderNotification;
use RealEstate\Core\Log\Entities\Log;
use RealEstate\Core\Log\Enums\Action;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class AwardOrderFactory extends AbstractOrderFactory
{
    /**
     * @param AwardOrderNotification $notification
     * @return Log
     */
    public function create($notification)
    {
        $log = parent::create($notification);

        $log->setAction(new Action(Action::AWARD_ORDER));

        return $log;
    }
}