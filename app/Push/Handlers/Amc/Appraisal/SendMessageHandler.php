<?php
namespace RealEstate\Push\Handlers\Amc\Appraisal;
use RealEstate\Core\Appraisal\Notifications\SendMessageNotification;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class SendMessageHandler extends BaseHandler
{
    /**
     * @param SendMessageNotification $notification
     * @return array
     */
    protected function transform($notification)
    {
        $data = parent::transform($notification);

        $data['event'] = 'send-message';
        $data['message'] = $notification->getMessage()->getId();

        return $data;
    }
}