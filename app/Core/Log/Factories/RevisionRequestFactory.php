<?php
namespace RealEstate\Core\Log\Factories;
use RealEstate\Core\Appraisal\Notifications\RevisionRequestNotification;
use RealEstate\Core\Log\Entities\Log;
use RealEstate\Core\Log\Enums\Action;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class RevisionRequestFactory extends AbstractOrderFactory
{
    /**
     * @param RevisionRequestNotification $notification
     * @return Log
     */
    public function create($notification)
    {
        $log = parent::create($notification);

        $log->setAction(new Action(Action::REVISION_REQUEST));

        return $log;
    }
}