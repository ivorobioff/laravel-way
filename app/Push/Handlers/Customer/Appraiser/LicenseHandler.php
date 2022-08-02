<?php
namespace RealEstate\Push\Handlers\Customer\Appraiser;
use RealEstate\Core\Appraiser\Notifications\AbstractLicenseNotification;
use RealEstate\Core\Appraiser\Notifications\DeleteLicenseNotification;
use RealEstate\Core\Appraiser\Notifications\UpdateLicenseNotification;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class LicenseHandler extends AbstractAppraiserHandler
{
    /**
     * @param AbstractLicenseNotification $notification
     * @return array
     */
    protected function transform($notification)
    {
        $data = parent::transform($notification);

        $event = 'create-license';

        if ($notification instanceof UpdateLicenseNotification){
            $event = 'update-license';
        }

        if ($notification instanceof DeleteLicenseNotification){
            $event = 'delete-license';
        }

        $data['license'] = $notification->getLicense()->getId();
        $data['event'] = $event;

        return $data;
    }
}