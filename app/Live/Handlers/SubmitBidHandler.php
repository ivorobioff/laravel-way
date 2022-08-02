<?php
namespace RealEstate\Live\Handlers;
use RealEstate\Core\Appraisal\Notifications\SubmitBidNotification;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class SubmitBidHandler extends AbstractOrderHandler
{
    /**
     * @return string
     */
    protected function getName()
    {
        return 'submit-bid';
    }

    /**
     * @param SubmitBidNotification $notification
     * @return array
     */
    protected function getData($notification)
    {
        return [
            'order' => $this->transformer()->transform($notification->getOrder()),
            'bid' => $this->transformer()->transform($notification->getOrder()->getBid())
        ];
    }
}