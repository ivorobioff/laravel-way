<?php
namespace RealEstate\Letter\Handlers\Appraisal;
use RealEstate\Core\Appraisal\Notifications\AbstractNotification;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class RevisionRequestHandler extends AbstractOrderHandler
{
    /**
     * @param AbstractNotification $notification
     * @return string
     */
    protected function getSubject(AbstractNotification $notification)
    {
        return 'Revision Request - Order on '.$notification->getOrder()->getProperty()->getDisplayAddress();
    }

    /**
     * @return string
     */
    protected function getTemplate()
    {
        return 'emails.appraisal.revision_request';
    }

    /**
     * @param AbstractNotification $notification
     * @return string
     */
    protected function getActionUrl(AbstractNotification $notification)
    {
        return $this->config->get('app.front_end_url').'/orders/details/'.$notification->getOrder()->getId().'/revisions';
    }
}