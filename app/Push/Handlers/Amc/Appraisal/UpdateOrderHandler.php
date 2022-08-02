<?php
namespace RealEstate\Push\Handlers\Amc\Appraisal;
use RealEstate\Core\Appraisal\Notifications\UpdateOrderNotification;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class UpdateOrderHandler extends BaseHandler
{
    /**
     * @param UpdateOrderNotification $notification
     * @return array
     */
    protected function transform($notification)
    {
        $data = parent::transform($notification);

        $data['event'] = 'update';

        return $data;
    }
}