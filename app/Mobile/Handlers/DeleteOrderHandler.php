<?php
namespace RealEstate\Mobile\Handlers;
use RealEstate\Core\Appraisal\Enums\ProcessStatus;
use RealEstate\Core\Appraisal\Notifications\AbstractNotification;
use RealEstate\Core\Appraisal\Notifications\DeleteOrderNotification;
use RealEstate\Mobile\Support\Tuple;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class DeleteOrderHandler extends AbstractOrderHandler
{
    /**
     * @param DeleteOrderNotification $notification
     * @return Tuple
     */
    public function handle($notification)
    {
        // we don't want to send push notification when a bit request is deleted

        if ($notification->getOrder()->getProcessStatus()->is(ProcessStatus::REQUEST_FOR_BID)){
            return null;
        }

        return parent::handle($notification);
    }

    /**
     * @param DeleteOrderNotification $notification
     * @return array
     */
    protected function getExtra($notification)
    {
        $order = $notification->getOrder();

        $data = parent::getExtra($notification);

        $data['fileNumber'] = $order->getFileNumber();
        $data['processStatus']  = (string) $order->getProcessStatus();

        return $data;
    }

    /**
     * @return string
     */
    protected function getName()
    {
        return 'delete';
    }

    /**
     * @param AbstractNotification $notification
     * @return string
     */
    protected function getMessage($notification)
    {
        $property = $notification->getOrder()->getProperty();

        return sprintf('%s has deleted the order on %s.',
            $this->session->getUser()->getDisplayName(),
            $property->getDisplayAddress()
        );
    }
}