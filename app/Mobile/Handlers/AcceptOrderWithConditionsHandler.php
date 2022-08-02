<?php
namespace RealEstate\Mobile\Handlers;
use RealEstate\Core\Appraisal\Notifications\AbstractNotification;
use RealEstate\Core\Appraisal\Notifications\AcceptOrderWithConditionsNotification;
use DateTime;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class AcceptOrderWithConditionsHandler extends AbstractOrderHandler
{
    /**
     * @param AbstractNotification $notification
     * @return string
     */
    protected function getMessage($notification)
    {
        $property = $notification->getOrder()->getProperty();

        return sprintf('%s has accepted the order on %s with conditions.',
            $this->session->getUser()->getDisplayName(),
            $property->getDisplayAddress()
        );
    }

    /**
     * @param AbstractNotification|AcceptOrderWithConditionsNotification $notification
     * @return array
     */
    protected function getExtra($notification)
    {
        $data = parent::getExtra($notification);

        $conditions = $notification->getConditions();

        $data['conditions'] = [
            'request' => (string) $conditions->getRequest(),
            'fee' => $conditions->getFee(),
            'explanation' => $conditions->getExplanation(),
            'dueDate' => $conditions->getDueDate()->format(DateTime::ATOM)
        ];

        return $data;
    }

    /**
     * @return string
     */
    protected function getName()
    {
        return 'accept-with-conditions';
    }
}