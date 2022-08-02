<?php
namespace RealEstate\Push\Handlers\Amc\Appraisal;
use RealEstate\Core\Appraisal\Notifications\CreateAdditionalDocumentNotification;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class CreateAdditionalDocumentHandler extends BaseHandler
{
    /**
     * @param CreateAdditionalDocumentNotification $notification
     * @return array
     */
    protected function transform($notification)
    {
        $data = parent::transform($notification);

        $data['event'] = 'create-additional-document';

        $data['additionalDocument'] = $notification->getAdditionalDocument()->getId();

        return $data;
    }
}