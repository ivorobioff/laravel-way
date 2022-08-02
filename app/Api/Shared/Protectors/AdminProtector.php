<?php
namespace RealEstate\Api\Shared\Protectors;
use RealEstate\Core\Back\Entities\Admin;
use RealEstate\Core\Session\Entities\Session;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class AdminProtector extends AuthProtector
{
    public function grants()
    {
        if (! parent::grants()) {
            return false;
        }

        /**
         * @var Session $session
         */
        $session = $this->container->make(Session::class);

        return $session->getUser() instanceof Admin;
    }
}