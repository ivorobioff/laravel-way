<?php
namespace RealEstate\Push\Handlers\Amc\Appraisal;
use RealEstate\Core\Appraisal\Notifications\DeleteAdditionalDocumentNotification;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class DeleteAdditionalDocumentHandler extends BaseHandler
{
    /**
     * @param DeleteAdditionalDocumentNotification $notification
     * @return array
     */
    protected function transform($notification)
    {
        $data = parent::transform($notification);

        $data['event'] = 'delete-additional-document';

        $data['additionalDocument'] = $notification->getAdditionalDocument()->getId();

        return $data;
    }
}