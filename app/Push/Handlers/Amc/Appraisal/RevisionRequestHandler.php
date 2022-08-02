<?php
namespace RealEstate\Push\Handlers\Amc\Appraisal;
use RealEstate\Core\Appraisal\Notifications\RevisionRequestNotification;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class RevisionRequestHandler extends BaseHandler
{
    /**
     * @param RevisionRequestNotification $notification
     * @return array
     */
    protected function transform($notification)
    {
        $data = parent::transform($notification);

        $data['event'] = 'revision-request';
        $data['revision'] = $notification->getRevision()->getId();

        return $data;
    }
}