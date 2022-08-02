<?php
namespace RealEstate\Push\Handlers\Amc\Appraisal;
use RealEstate\Core\Amc\Entities\Amc;
use RealEstate\Core\Log\Notifications\CreateLogNotification;
use RealEstate\Push\Support\AbstractHandler;
use RealEstate\Push\Support\Call;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class CreateLogHandler extends AbstractHandler
{
    use CallsCapableTrait;

    /**
     * @param CreateLogNotification $notification
     * @return Call[]
     */
    protected function getCalls($notification)
    {
        $amc = $notification->getLog()->getAssignee();

        if (!$amc instanceof Amc){
            return [];
        }

        return $this->createCalls($amc);
    }

    /**
     * @param CreateLogNotification $notification
     * @return array
     */
    protected function transform($notification)
    {
        return [
            'type' => 'order',
            'event' => 'create-log',
            'order' => object_take($notification, 'log.order.id'),
            'log' => $notification->getLog()->getId()
        ];
    }
}