<?php
namespace RealEstate\Push\Handlers\Amc\Appraisal;
use RealEstate\Core\Appraisal\Notifications\BidRequestNotification;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class BidRequestHandler extends BaseHandler
{
    /**
     * @param BidRequestNotification $notification
     * @return array
     */
    protected function transform($notification)
    {
        $data = parent::transform($notification);

        $data['event'] = 'bid-request';

        return $data;
    }
}