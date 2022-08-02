<?php
namespace RealEstate\Core\Appraisal\Notifications;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
interface UpdateProcessStatusNotificationAwareInterface
{
    /**
     * @param UpdateProcessStatusNotification $notification
     */
    public function setUpdateProcessStatusNotification(UpdateProcessStatusNotification $notification);

    /**
     * @return UpdateProcessStatusNotification
     */
    public function getUpdateProcessStatusNotification();
}