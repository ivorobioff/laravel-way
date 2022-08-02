<?php
namespace RealEstate\Core\Appraisal\Notifications;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
trait UpdateProcessStatusNotificationAwareTrait
{
    /**
     * @var UpdateProcessStatusNotification
     */
    private $updateProcessStatusNotification;

    /**
     * @param UpdateProcessStatusNotification $notification
     */
    public function setUpdateProcessStatusNotification(UpdateProcessStatusNotification $notification)
    {
        $this->updateProcessStatusNotification = $notification;
    }

    /**
     * @return UpdateProcessStatusNotification
     */
    public function getUpdateProcessStatusNotification()
    {
        return $this->updateProcessStatusNotification;
    }
}