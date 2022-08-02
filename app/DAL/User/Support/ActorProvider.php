<?php
namespace RealEstate\DAL\User\Support;
use RealEstate\Core\Session\Entities\Session;
use RealEstate\Core\User\Entities\User;
use RealEstate\Core\User\Interfaces\ActorProviderInterface;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class ActorProvider implements ActorProviderInterface
{
    /**
     * @var Session
     */
    private $session;

    /**
     * @param Session $session
     */
    public function __construct(Session $session)
    {
        $this->session = $session;
    }


    /**
     * @return User
     */
    public function getActor()
    {
        return $this->session->getUser();
    }
}