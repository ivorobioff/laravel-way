<?php
namespace RealEstate\Core\User\Interfaces;
use RealEstate\Core\User\Entities\User;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
interface ActorProviderInterface
{
    /**
     * @return User
     */
    public function getActor();
}