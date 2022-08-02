<?php
namespace RealEstate\Push\Handlers\Amc\Appraisal;
use RealEstate\Core\Appraisal\Notifications\CreateDocumentNotification;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class CreateDocumentHandler extends BaseHandler
{
    /**
     * @param CreateDocumentNotification $notification
     * @return array
     */
    protected function transform($notification)
    {
        $data = parent::transform($notification);

        $data['event'] = 'create-document';

        $data['document'] = $notification->getDocument()->getId();

        return $data;
    }
}