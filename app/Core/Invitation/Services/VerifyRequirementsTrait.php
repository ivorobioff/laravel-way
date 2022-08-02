<?php
namespace RealEstate\Core\Invitation\Services;

use RealEstate\Core\Appraiser\Entities\Appraiser;
use RealEstate\Core\Appraiser\Services\AppraiserService;
use RealEstate\Core\Invitation\Enums\Requirement;
use RealEstate\Core\Invitation\Enums\Requirements;

trait VerifyRequirementsTrait
{
    /**
     * @param Requirements $requirements
     * @param Appraiser $appraiser
     * @return bool
     */
    private function verifyRequirements(Requirements $requirements, Appraiser $appraiser)
    {
        if ($requirements->has(new Requirement(Requirement::ACH))){

            /**
             * @var AppraiserService $appraiserService
             */
            $appraiserService = $this->container->get(AppraiserService::class);

            if (!$appraiserService->hasAch($appraiser->getId())){
                return false;
            }
        }

        if ($requirements->has(new Requirement(Requirement::RESUME))
            && $appraiser->getQualifications()->getResume() === null){
            return false;
        }

        if ($requirements->has(new Requirement(Requirement::SAMPLE_REPORTS))
            && count($appraiser->getSampleReports()) === 0){
            return false;
        }

        return true;
    }
}
