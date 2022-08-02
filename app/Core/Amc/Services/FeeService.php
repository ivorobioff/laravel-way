<?php
namespace RealEstate\Core\Amc\Services;
use RealEstate\Core\Amc\Entities\Amc;
use RealEstate\Core\Amc\Entities\Fee;
use RealEstate\Core\Amc\Entities\FeeByState;
use RealEstate\Core\Assignee\Persistables\FeePersistable;
use RealEstate\Core\Support\Synchronizer;
use RealEstate\Core\Amc\Validation\SyncFeesValidator;
use RealEstate\Core\Assignee\Entities\CustomerFee;
use RealEstate\Core\Assignee\Objects\Total;
use RealEstate\Core\Customer\Entities\Customer;
use RealEstate\Core\JobType\Entities\JobType;
use RealEstate\Core\JobType\Services\JobTypeService;
use RealEstate\Core\Support\Service\AbstractService;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class FeeService extends AbstractService
{
    /**
     * @param int $amcId
     * @return Fee[]
     */
    public function getAllEnabled($amcId)
    {
        return $this->entityManager->getRepository(Fee::class)
            ->findBy(['amc' => $amcId, 'isEnabled' => true]);
    }

    /**
     * @param int $id
     * @return Fee
     */
    public function get($id)
    {
        return $this->entityManager->find(Fee::class, $id);
    }

    /**
     * @param int $amcId
     * @param int $jobTypeId
     * @return Fee
     */
    public function getByJobTypeId($amcId, $jobTypeId)
    {
        return $this->entityManager->getRepository(Fee::class)
            ->findOneBy(['amc' => $amcId, 'jobType' => $jobTypeId]);
    }

    /**
     * @param int $amcId
     * @param FeePersistable[] $persistables
     * @return Fee[]
     */
    public function sync($amcId, array $persistables)
    {
        /**
         * @var JobTypeService $jobTypeService
         */
        $jobTypeService = $this->container->get(JobTypeService::class);

        (new SyncFeesValidator($jobTypeService))->validate(['data' => $persistables]);

        /**
         * @var Amc $amc
         */
        $amc = $this->entityManager->getReference(Amc::class, $amcId);

        /**
         * @var Fee[]|object[] $fees
         */
        $fees = $this->entityManager->getRepository(Fee::class)
            ->findBy(['amc' => $amcId]);


        $synchronizer = new Synchronizer();

        $synchronizer
            ->identify1(function(Fee $fee){
                return $fee->getJobType()->getId();
            })
            ->identify2(function(FeePersistable $persistable){
                return $persistable->getJobType();
            })
            ->onRemove(function(Fee $fee){
                $fee->setEnabled(false);
            })
            ->onCreate(function(FeePersistable $persistable) use ($amc) {
                return $this->createInMemory($amc, $persistable);
            })
            ->onUpdate(function(Fee $fee, FeePersistable $persistable){
                $fee->setEnabled(true);
                $this->updateInMemory($fee, $persistable);
            });

        $result = $synchronizer->synchronize($fees, $persistables);

        $this->entityManager->flush();

        return $result;
    }

    /**
     * @param Amc $amc
     * @param FeePersistable $persistable
     * @return Fee
     */
    private function createInMemory(Amc $amc, FeePersistable $persistable)
    {
        $fee = new Fee();

        $fee->setAmc($amc);

        $this->exchange($persistable, $fee);

        $this->entityManager->persist($fee);

        return $fee;
    }

    /**
     * @param Fee $fee
     * @param FeePersistable $persistable
     */
    private function updateInMemory(Fee $fee, FeePersistable $persistable)
    {
        $this->exchange($persistable, $fee);
    }

    /**
     * @param FeePersistable $persistable
     * @param Fee $fee
     */
    private function exchange(FeePersistable $persistable, Fee $fee)
    {
        $this->transfer($persistable, $fee, [
            'ignore' => [
                'jobType'
            ]
        ]);

        if ($persistable->getJobType()){
            /**
             * @var JobType $jobType
             */
            $jobType = $this->entityManager->getReference(JobType::class, $persistable->getJobType());

            $fee->setJobType($jobType);
        }
    }

    /**
     * @param int $feeId
     * @param string $code
     * @return bool
     */
    public function hasFeeByStateByStateCode($feeId, $code)
    {
        return $this->entityManager->getRepository(FeeByState::class)
            ->exists(['fee' => $feeId, 'state' => $code]);
    }

    /**
     * @param int $amcId
     * @return Total[]
     */
    public function getTotals($amcId)
    {
        $enabledDefault = $this->entityManager->getRepository(Fee::class)
            ->count(['amc' => $amcId, 'isEnabled' => 1]);


        $totals = [];

        $defaultTotal = new Total();
        $defaultTotal->setEnabled($enabledDefault);

        $totals[] = $defaultTotal;


        $builder = $this->entityManager->createQueryBuilder();

        $data = $builder->select('COUNT(f.id) AS total', 'IDENTITY(f.customer) AS customer')
            ->from(CustomerFee::class, 'f')
            ->where($builder->expr()->eq('f.assignee', ':amc'))
            ->groupBy('f.customer')
            ->setParameter('amc', $amcId)
            ->getQuery()
            ->getResult();

        $map = [];

        foreach ($data as $row){
            $map[$row['customer']] = (int) $row['total'];
        }

        /**
         * @var Customer[] $customers
         */
        $customers = $this->entityManager->getRepository(Customer::class)
            ->retrieveAll(['id' => ['in', array_keys($map)]]);

        foreach ($customers as $customer){
            $total = new Total();
            $total->setEnabled($map[$customer->getId()]);
            $total->setCustomer($customer);
            $totals[] = $total;
        }

        return $totals;
    }
}
