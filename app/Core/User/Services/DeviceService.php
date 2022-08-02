<?php
namespace RealEstate\Core\User\Services;

use RealEstate\Core\Support\Service\AbstractService;
use RealEstate\Core\User\Entities\Device;
use RealEstate\Core\User\Entities\User;
use RealEstate\Core\User\Interfaces\DevicePreferenceInterface;
use RealEstate\Core\User\Persistables\DevicePersistable;
use RealEstate\Core\User\Validation\DeviceValidator;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class DeviceService extends AbstractService
{
	/**
	 * @param array $userIds
	 * @return Device[]
	 */
	public function getAllByUserIds(array $userIds)
	{
		return $this->entityManager
			->getRepository(Device::class)
			->retrieveAll(['user' => ['in', $userIds]]);
	}

	/**
	 * @param int $userId
	 * @param DevicePersistable $persistable
	 * @return Device
	 */
	public function createIfNeeded($userId, DevicePersistable $persistable)
	{
		/**
		 * @var DevicePreferenceInterface $preference
		 */
		$preference = $this->container->get(DevicePreferenceInterface::class);

		(new DeviceValidator($preference))->validate($persistable);

		/**
		 * @var Device $device
		 */
		$device = $this->entityManager->getRepository(Device::class)
			->findOneBy([
				'token' => $persistable->getToken(),
				'platform' => $persistable->getPlatform()
			]);

		if ($device){
			if ($device->getUser()->getId() == $userId){
				return $device;
			}

			$this->entityManager->remove($device);
		}

		/**
		 * @var User $user
		 */
		$user = $this->entityManager->find(User::class, $userId);

		$device = new Device();
		$this->transfer($persistable, $device);

		$device->setUser($user);

		$this->entityManager->persist($device);
		$this->entityManager->flush();

		return $device;
	}

	/**
	 * @param int $id
	 */
	public function delete($id)
	{
		$this->entityManager->getRepository(Device::class)->delete(['id' => $id]);
	}

    /**
     * @param string $token
     */
	public function deleteByToken($token)
    {
        $this->entityManager->getRepository(Device::class)->delete(['token' => $token]);
    }
}