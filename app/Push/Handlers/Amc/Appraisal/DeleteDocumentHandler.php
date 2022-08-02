<?php
namespace RealEstate\Push\Handlers\Amc\Appraisal;
use RealEstate\Core\Appraisal\Notifications\DeleteDocumentNotification;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class DeleteDocumentHandler extends BaseHandler
{
    /**
     * @param DeleteDocumentNotification $notification
     * @return array
     */
    protected function transform($notification)
    {
        $data = parent::transform($notification);

        $data['event'] = 'delete-document';

        $data['document'] = $notification->getDocument()->getId();

        return $data;
    }
}