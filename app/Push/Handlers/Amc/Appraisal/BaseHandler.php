<?php
namespace RealEstate\Push\Handlers\Amc\Appraisal;
use RealEstate\Core\Amc\Entities\Amc;
use RealEstate\Core\Appraisal\Notifications\AbstractNotification;
use RealEstate\Push\Support\AbstractHandler;
use RealEstate\Push\Support\Call;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
abstract class BaseHandler extends AbstractHandler
{
    use CallsCapableTrait;

    /**
     * @param AbstractNotification $notification
     * @return Call[]
     */
    protected function getCalls($notification)
    {
        $amc = $notification->getOrder()->getAssignee();

        if (!$amc instanceof Amc){
            return [];
        }

        return $this->createCalls($amc);
    }

    /**
     * @param AbstractNotification $notification
     * @return array
     */
    protected function transform($notification)
    {
        return [
            'type' => 'order',
            'order' => $notification->getOrder()->getId()
        ];
    }
}