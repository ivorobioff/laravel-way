<?php
namespace RealEstate\Push\Handlers\Amc\Appraisal;
use RealEstate\Core\Appraisal\Notifications\UpdateDocumentNotification;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class UpdateDocumentHandler extends BaseHandler
{
    /**
     * @param UpdateDocumentNotification $notification
     * @return array
     */
    protected function transform($notification)
    {
        $data = parent::transform($notification);

        $data['event'] = 'update-document';
        $data['document'] = $notification->getDocument()->getId();

        return $data;
    }
}