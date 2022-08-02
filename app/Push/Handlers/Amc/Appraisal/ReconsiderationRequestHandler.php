<?php
namespace RealEstate\Push\Handlers\Amc\Appraisal;
use RealEstate\Core\Appraisal\Notifications\ReconsiderationRequestNotification;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class ReconsiderationRequestHandler extends BaseHandler
{
    /**
     * @param ReconsiderationRequestNotification $notification
     * @return array
     */
    protected function transform($notification)
    {
        $data = parent::transform($notification);

        $data['event'] = 'reconsideration-request';
        $data['reconsideration'] = $notification->getReconsideration()->getId();

        return $data;
    }
}