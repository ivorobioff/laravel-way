<?php
namespace RealEstate\Api\Customer\V2_0\Controllers;

use Illuminate\Http\Response;
use RealEstate\Api\Customer\V2_0\Processors\SettingsProcessor;
use RealEstate\Api\Customer\V2_0\Transformers\SettingsTransformer;
use RealEstate\Api\Support\BaseController;
use RealEstate\Core\Customer\Services\CustomerService;
use RealEstate\Core\Customer\Services\SettingsService;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class SettingsController extends BaseController
{
	/**
	 * @var SettingsService
	 */
	private $settingsService;

	/**
	 * @param SettingsService $settingsService
	 */
	public function initialize(SettingsService $settingsService)
	{
		$this->settingsService = $settingsService;
	}

	/**
	 * @param int $customerId
	 * @return Response
	 */
	public function show($customerId)
	{
		return $this->resource->make(
			$this->settingsService->get($customerId),
			$this->transformer(SettingsTransformer::class)
		);
	}

	/**
	 * @param int $customerId
	 * @param SettingsProcessor $processor
	 * @return Response
	 */
	public function update($customerId, SettingsProcessor $processor)
	{
		$this->settingsService->update(
			$customerId,
			$processor->createPersistable(),
			$processor->schedulePropertiesToClear()
		);

		return $this->resource->blank();
	}

	/**
	 * @param CustomerService $customerService
	 * @param int $customerId
	 * @return bool
	 */
	public static function verifyAction(CustomerService $customerService, $customerId)
	{
		return $customerService->exists($customerId);
	}
}