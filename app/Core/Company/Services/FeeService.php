<?php
namespace RealEstate\Core\Company\Services;
use RealEstate\Core\Company\Entities\Company;
use RealEstate\Core\Company\Entities\Fee;
use RealEstate\Core\Company\Persistables\FeePersistable;
use RealEstate\Core\Company\Validation\SyncFeesValidator;
use RealEstate\Core\JobType\Entities\JobType;
use RealEstate\Core\JobType\Services\JobTypeService;
use RealEstate\Core\Support\Service\AbstractService;
use RealEstate\Core\Support\Synchronizer;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class FeeService extends AbstractService
{
    /**
     * @param int $companyId
     * @return Fee[]
     */
    public function getAll($companyId)
    {
        return $this->entityManager->getRepository(Fee::class)
            ->findBy(['company' => $companyId]);
    }

    /**
     * @param int $companyId
     * @param FeePersistable[] $persistables
     */
    public function sync($companyId, array $persistables)
    {
        /**
         * @var JobTypeService $jobTypeService
         */
        $jobTypeService = $this->container->get(JobTypeService::class);

        (new SyncFeesValidator($jobTypeService))->validate(['data' => $persistables]);

        $fees = $this->entityManager->getRepository(Fee::class)
            ->findBy(['company' => $companyId]);

        /**
         * @var Company $company
         */
        $company = $this->entityManager->getReference(Company::class, $companyId);

        (new Synchronizer())
            ->identify1(function(Fee $fee){
                return $fee->getJobType()->getId();
            })
            ->identify2(function(FeePersistable $persistable){
                return $persistable->getJobType();
            })
            ->onCreate(function(FeePersistable $persistable) use ($company){
                $fee = new Fee();

                $fee->setAmount($persistable->getAmount());
                $fee->setCompany($company);

                /**
                 * @var JobType $jobType
                 */
                $jobType = $this->entityManager->getReference(JobType::class, $persistable->getJobType());

                $fee->setJobType($jobType);

                $this->entityManager->persist($fee);

                return $fee;
            })
            ->onUpdate(function(Fee $fee, FeePersistable $persistable){
                $fee->setAmount($persistable->getAmount());
            })
            ->onRemove(function(Fee $fee){
                $this->entityManager->remove($fee);
            })
            ->synchronize($fees, $persistables);

        $this->entityManager->flush();
    }
}