<?php
namespace RealEstate\Core\Appraisal\Notifications;
use RealEstate\Core\Appraisal\Entities\Order;
use RealEstate\Core\Appraisal\Entities\Revision;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class RevisionRequestNotification extends AbstractNotification implements UpdateProcessStatusNotificationAwareInterface
{
    use UpdateProcessStatusNotificationAwareTrait;

    /**
     * @var Revision
     */
    private $revision;

    /**
     * @param Order $order
     * @param Revision $revision
     */
    public function __construct(Order $order, Revision $revision)
    {
        parent::__construct($order);

        $this->revision = $revision;
    }

    /**
     * @return Revision
     */
    public function getRevision()
    {
        return $this->revision;
    }
}