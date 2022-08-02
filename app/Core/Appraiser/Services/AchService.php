<?php
namespace RealEstate\Core\Appraiser\Services;

use RealEstate\Core\Appraiser\Notifications\UpdateAchNotification;
use RealEstate\Core\Appraiser\Entities\Ach;
use RealEstate\Core\Appraiser\Entities\Appraiser;
use RealEstate\Core\Appraiser\Persistables\AchPersistable;
use RealEstate\Core\Appraiser\Validation\AchValidator;
use RealEstate\Core\Support\Service\AbstractService;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class AchService extends AbstractService
{
	/**
	 * @param int $appraiserId
	 * @param AchPersistable $persistable
	 * @return Ach
	 */
	public function replace($appraiserId, AchPersistable $persistable)
	{
		(new AchValidator())->validate($persistable);

        /**
         * @var Appraiser $appraiser
         */
        $appraiser = $this->entityManager->find(Appraiser::class, $appraiserId);

		/**
		 * @var Ach $ach
		 */
		$ach = $appraiser->getAch();

		if ($ach === null){
			$ach = new Ach();
		}


		$this->transfer($persistable, $ach);

		if ($ach->getId() === null){
			$this->entityManager->persist($ach);
		}

		$appraiser->setAch($ach);

		$this->entityManager->flush();

        $this->notify(new UpdateAchNotification($ach, $appraiser));

		return $ach;
	}

	/**
	 * @param int $appraiserId
	 * @return Ach
	 */
	public function getExistingOrEmpty($appraiserId)
	{
        /**
         * @var Appraiser $appraiser
         */
        $appraiser = $this->entityManager->find(Appraiser::class, $appraiserId);

        return $appraiser->getAch() ?? new Ach();
	}
}