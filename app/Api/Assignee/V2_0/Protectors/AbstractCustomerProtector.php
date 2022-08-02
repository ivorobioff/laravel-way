<?php
namespace RealEstate\Api\Assignee\V2_0\Protectors;

use RealEstate\Api\Shared\Protectors\AuthProtector;
use Illuminate\Http\Request;
use RealEstate\Core\Customer\Entities\Customer;
use RealEstate\Core\Session\Entities\Session;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
abstract class AbstractCustomerProtector extends AuthProtector
{
    public function grants()
    {
        if (!parent::grants()){
            return false;
        }

        /**
         * @var Request $request
         */
        $request = $this->container->make('request');

        $assigneeId = (int) array_values($request->route()->parameters())[0];

        /**
         * @var Session $session
         */
        $session = $this->container->make(Session::class);

        $customer = $session->getUser();

        if (!$customer instanceof Customer){
            return false;
        }

        return $this->isRelated($customer->getId(), $assigneeId);
    }

    /**
     * @param int $customerId
     * @param int $assigneeId
     * @return bool
     */
    abstract function isRelated($customerId, $assigneeId);
}