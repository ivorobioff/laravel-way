<?php
namespace RealEstate\Api\Appraisal\V2_0\Support;
use RealEstate\Core\Customer\Entities\Customer;
use RealEstate\Core\Session\Entities\Session;
use RealEstate\Core\Shared\Interfaces\EnvironmentInterface;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class MessageReaderResolver
{
    /**
     * @var Session
     */
    private $session;

    /**
     * @var EnvironmentInterface
     */
    private $environment;

    /**
     * @param Session $session
     * @param EnvironmentInterface $environment
     */
    public function __construct(Session $session, EnvironmentInterface $environment)
    {
        $this->session = $session;
        $this->environment = $environment;
    }

    public function getReader()
    {
        $user = $this->session->getUser();

        if (!$user instanceof Customer){
            return $user->getId();
        }

        if ($assignee = $this->environment->getAssigneeAsWhoActorActs()){
            return $assignee;
        }

        return $user->getId();
    }
}