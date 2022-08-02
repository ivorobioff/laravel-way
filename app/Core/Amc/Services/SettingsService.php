<?php
namespace RealEstate\Core\Amc\Services;
use RealEstate\Core\Amc\Entities\Settings;
use RealEstate\Core\Amc\Persistables\SettingsPersistable;
use RealEstate\Core\Amc\Validation\SettingsValidator;
use RealEstate\Core\Shared\Options\UpdateOptions;
use RealEstate\Core\Support\Service\AbstractService;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class SettingsService extends AbstractService
{
    /**
     * @param int $amcId
     * @return Settings
     */
    public function get($amcId)
    {
        return $this->entityManager->getRepository(Settings::class)
            ->findOneBy(['amc' => $amcId]);
    }

    /**
     * @param int $amcId
     * @param SettingsPersistable $persistable
     * @param UpdateOptions $options
     */
    public function update($amcId, SettingsPersistable $persistable, UpdateOptions $options)
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
        $settings = $this->entityManager->getRepository(Settings::class)
            ->findOneBy(['amc' => $amcId]);

        $this->transfer($persistable, $settings, [
            'nullable' => $options->getPropertiesScheduledToClear()
        ]);

        $this->entityManager->flush();
    }
}