<?php
namespace RealEstate\Push\Handlers\Amc\Appraisal;
use RealEstate\Core\Appraisal\Notifications\ChangeAdditionalStatusNotification;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class ChangeAdditionalStatusHandler extends BaseHandler
{
    /**
     * @param ChangeAdditionalStatusNotification $notification
     * @return array
     */
    protected function transform($notification)
    {
        $data = parent::transform($notification);

        $data['event'] = 'change-additional-status';

        $data = array_merge($data, [
            'oldAdditionalStatus' => object_take($notification->getOldAdditionalStatus(), 'id'),
            'oldAdditionalStatusComment' => $notification->getOldAdditionalStatusComment(),
            'newAdditionalStatus' => object_take($notification->getNewAdditionalStatus(), 'id'),
            'newAdditionalStatusComment' => $notification->getNewAdditionalStatusComment(),
        ]);

        return $data;
    }
}