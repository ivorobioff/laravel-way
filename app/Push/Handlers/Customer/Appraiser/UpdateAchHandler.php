<?php
namespace RealEstate\Push\Handlers\Customer\Appraiser;
use RealEstate\Core\Appraiser\Notifications\UpdateAppraiserNotification;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class UpdateAchHandler extends AbstractAppraiserHandler
{
    /**
     * @param UpdateAppraiserNotification $notification
     * @return array
     */
    protected function transform($notification)
    {
        $data = parent::transform($notification);

        $data['event'] = 'update-ach';

        return $data;
    }
}