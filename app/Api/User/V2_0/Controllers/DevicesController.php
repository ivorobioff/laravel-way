<?php
namespace RealEstate\Api\User\V2_0\Controllers;

use Illuminate\Http\Response;
use RealEstate\Api\Support\BaseController;
use RealEstate\Api\User\V2_0\Processors\DevicesProcessor;
use RealEstate\Api\User\V2_0\Transformers\DeviceTransformer;
use RealEstate\Core\User\Services\DeviceService;
use RealEstate\Core\User\Services\UserService;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class DevicesController extends BaseController
{
	/**
	 * @var DeviceService
	 */
	private $deviceService;

	/**
	 * @param DeviceService $deviceService
	 */
	public function initialize(DeviceService $deviceService)
	{
		$this->deviceService = $deviceService;
	}

	/**
	 * @param int $userId
	 * @param DevicesProcessor $processor
	 * @return Response
	 */
	public function store($userId, DevicesProcessor $processor)
	{
		return $this->resource->make(
			$this->deviceService->createIfNeeded($userId, $processor->createPersistable()),
			$this->transformer(DeviceTransformer::class)
		);
	}

	/**
	 * @param int $userId
	 * @param int $deviceId
	 * @return bool
	 */
	public function destroy($userId, $deviceId)
	{
		$this->deviceService->delete($deviceId);

		return $this->resource->blank();
	}

	/**
	 * @param UserService $userService
	 * @param int $userId
	 * @return bool
	 */
	public static function verifyAction(UserService $userService, $userId)
	{
		return $userService->exists($userId);
	}
}