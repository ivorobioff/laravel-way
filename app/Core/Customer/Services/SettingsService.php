<?php
namespace RealEstate\Core\Customer\Services;

use RealEstate\Core\Customer\Entities\Settings;
use RealEstate\Core\Customer\Persistables\SettingsPersistable;
use RealEstate\Core\Customer\Validation\SettingsValidator;
use RealEstate\Core\Shared\Options\UpdateOptions;
use RealEstate\Core\Support\Service\AbstractService;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class SettingsService extends AbstractService
{
	/**
	 * @param int $customerId
	 * @param SettingsPersistable $persistable
	 * @param UpdateOptions $options = null
	 */
	public function update($customerId, SettingsPersistable $persistable, UpdateOptions $options = null)
	{
		if ($options === null){
			$options = new UpdateOptions();
		}

		(new SettingsValidator())
			->setForcedProperties($options->getPropertiesScheduledToClear())
			->validate($persistable, true);

		/**
		 * @var Settings $settings
		 */
		$settings = $this->entityManager->find(Settings::class, $customerId);

		$this->transfer($persistable, $settings, [
			'nullable' => $options->getPropertiesScheduledToClear()
		]);

		$this->entityManager->flush();
	}

	/**
	 * @param int $customerId
	 * @return Settings
	 */
	public function get($customerId)
	{
		return $this->entityManager->find(Settings::class, $customerId);
	}

	/**
	 * @param array $customerIds
	 * @return Settings[]
	 */
	public function getAllBySelectedCustomers(array $customerIds)
	{
		return $this->entityManager->getRepository(Settings::class)
			->retrieveAll(['customer' => ['in', $customerIds]]);
	}
}