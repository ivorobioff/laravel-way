<?php
namespace RealEstate\Api\Company\V2_0\Protectors;

use RealEstate\Api\Shared\Protectors\AuthProtector;
use RealEstate\Core\Appraiser\Entities\Appraiser;
use RealEstate\Core\Session\Entities\Session;

class AppraiserProtector extends AuthProtector
{
    /**
     * @return bool
     */
    public function grants()
    {
        if (! parent::grants()) {
            return false;
        }

        $session = $this->container->make(Session::class);

        return $session->getUser() instanceof Appraiser;
    }
}
