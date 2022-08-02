<?php
namespace RealEstate\Push\Handlers\Amc\Appraisal;
use RealEstate\Core\Appraisal\Notifications\CreateOrderNotification;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class CreateOrderHandler extends BaseHandler
{
    /**
     * @param CreateOrderNotification $notification
     * @return array
     */
    protected function transform($notification)
    {
        $data = parent::transform($notification);

        $data['event'] = 'create';

        return $data;
    }
}