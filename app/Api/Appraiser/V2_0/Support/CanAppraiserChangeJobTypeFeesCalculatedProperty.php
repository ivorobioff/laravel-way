<?php
namespace RealEstate\Api\Appraiser\V2_0\Support;

use RealEstate\Core\Appraiser\Services\AppraiserService;
use RealEstate\Core\Customer\Entities\Settings;
use RealEstate\Core\Session\Entities\Session;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class CanAppraiserChangeJobTypeFeesCalculatedProperty
{
	/**
	 * @var AppraiserService
	 */
	private $appraiserService;

	/**
	 * @var Session
	 */
	private $session;

	/**
	 * @param AppraiserService $appraiserService
	 * @param Session $session
	 */
	public function __construct(AppraiserService $appraiserService, Session $session)
	{
		$this->appraiserService = $appraiserService;
		$this->session = $session;
	}

	/**
	 * @param Settings $settings
	 * @return bool
	 */
	public function __invoke(Settings $settings)
	{
		return $settings->getDisallowChangeJobTypeFees() === false
			|| !$this->appraiserService->hasAnyCustomerFee(
				$this->session->getUser()->getId(),
				$settings->getCustomer()->getId());
	}
}