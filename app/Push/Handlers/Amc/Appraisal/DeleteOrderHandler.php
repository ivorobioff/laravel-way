<?php
namespace RealEstate\Push\Handlers\Amc\Appraisal;
use RealEstate\Core\Appraisal\Notifications\DeleteOrderNotification;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class DeleteOrderHandler extends BaseHandler
{
    /**
     * @param DeleteOrderNotification $notification
     * @return array
     */
    protected function transform($notification)
    {
        $data = parent::transform($notification);

        $data['event'] = 'delete';

        return $data;
    }
}