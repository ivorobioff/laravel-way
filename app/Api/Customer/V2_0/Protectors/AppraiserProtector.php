<?php
namespace RealEstate\Api\Customer\V2_0\Protectors;

use Illuminate\Http\Request;
use RealEstate\Api\Shared\Protectors\AuthProtector;
use RealEstate\Core\Customer\Services\CustomerService;
use RealEstate\Core\Session\Entities\Session;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class AppraiserProtector extends AuthProtector
{
	/**
	 * @return bool
	 */
	public function grants()
	{
		if (!parent::grants()){
			return false;
		}

		/**
		 * @var Request $request
		 */
		$request = $this->container->make('request');

		$customerId = (int) array_values($request->route()->parameters())[0];

		/**
		 * @var Session $session
		 */
		$session = $this->container->make(Session::class);

		/**
		 * @var CustomerService $customerService
		 */
		$customerService = $this->container->make(CustomerService::class);

		return $customerService->isRelatedWithAppraiser($customerId, $session->getUser()->getId());
	}
}