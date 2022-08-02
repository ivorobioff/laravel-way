<?php
namespace RealEstate\Core\Log\Factories;
use RealEstate\Core\Appraisal\Notifications\ReconsiderationRequestNotification;
use RealEstate\Core\Log\Enums\Action;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class ReconsiderationRequestFactory extends AbstractOrderFactory
{
    /**
     * @param ReconsiderationRequestNotification $notification
     * @return Log
     */
    public function create($notification)
    {
        $log = parent::create($notification);

        $log->setAction(new Action(Action::RECONSIDERATION_REQUEST));

        return $log;
    }
}