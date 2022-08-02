<?php
namespace RealEstate\Push\Handlers\Amc\Appraisal;
use RealEstate\Core\Appraisal\Notifications\AwardOrderNotification;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class AwardOrderHandler extends BaseHandler
{
    /**
     * @param AwardOrderNotification $notification
     * @return array
     */
    protected function transform($notification)
    {
        $data = parent::transform($notification);

        $data['event'] = 'award';

        return $data;
    }
}