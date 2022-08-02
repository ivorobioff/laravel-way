<?php
namespace RealEstate\Core\Assignee\Services;

use RealEstate\Core\Appraisal\Entities\Reconsideration;
use RealEstate\Core\Appraisal\Entities\Revision;
use RealEstate\Core\Appraisal\Services\OrderService;
use RealEstate\Core\Assignee\Entities\CustomerFee;
use RealEstate\Core\Log\Entities\Log;
use RealEstate\Core\Support\Service\AbstractService;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
abstract class AssigneeService extends AbstractService
{
    /**
     * @param int $assigneeId
     * @param int $orderId
     * @param bool $withSubordinates
     * @return bool
     */
    public function hasOrder($assigneeId, $orderId, $withSubordinates = false)
    {
        /**
         * @var OrderService $orderService
         */
        $orderService = $this->container->get(OrderService::class);

        return $orderService->existsByAssigneeId($orderId, $assigneeId, $withSubordinates);
    }

    /**
     * @param int $assigneeId
     * @param int $logId
     * @return bool
     */
    public function hasLog($assigneeId, $logId)
    {
        return $this->entityManager->getRepository(Log::class)
            ->exists(['assignee' => $assigneeId, 'id' => $logId]);
    }

    /**
     * @param int $assigneeId
     * @param int $revisionId
     * @return bool
     */
    public function hasRevision($assigneeId, $revisionId)
    {
        /**
         * @var Revision $revision
         */
        $revision = $this->entityManager->find(Revision::class, $revisionId);

        if (!$revision){
            return false;
        }

        return $revision->getOrder()->getAssignee()->getId() == $assigneeId;
    }

    /**
     * @param int $assigneeId
     * @param int $reconsiderationId
     * @return bool
     */
    public function hasReconsideration($assigneeId, $reconsiderationId)
    {
        /**
         * @var Reconsideration $reconsideration
         */
        $reconsideration = $this->entityManager->find(Reconsideration::class, $reconsiderationId);

        if (!$reconsideration){
            return false;
        }

        return $reconsideration->getOrder()->getAssignee()->getId() == $assigneeId;
    }

    /**
     * @param int $assigneeId
     * @param int $customerId
     * @param int $feeId
     * @return bool
     */
    public function hasCustomerFee($assigneeId, $customerId, $feeId)
    {
        return $this->entityManager
            ->getRepository(CustomerFee::class)
            ->exists(['id' => $feeId, 'assignee' => $assigneeId, 'customer' => $customerId]);
    }

    /**
     * @param int $assigneeId
     * @param int $customerId
     * @return bool
     */
    public function hasAnyCustomerFee($assigneeId, $customerId)
    {
        return $this->entityManager->getRepository(CustomerFee::class)
            ->exists(['assignee' => $assigneeId, 'customer' => $customerId]);
    }

    /**
     * @param int $assigneeId
     * @param int $customerId
     * @param int $jobTypeId
     * @return bool
     */
    public function hasCustomerFeeWithJobType($assigneeId, $customerId, $jobTypeId)
    {
        return $this->entityManager
            ->getRepository(CustomerFee::class)
            ->exists(['jobType' => $jobTypeId, 'assignee' => $assigneeId, 'customer' => $customerId]);
    }

    /**
     * @param int $assigneeId
     * @param int $customerId
     * @param array $jobTypeIds
     */
    public function hasCustomerFeesWithJobTypes($assigneeId, $customerId, array $jobTypeIds)
    {
        return $this->entityManager
            ->getRepository(CustomerFee::class)
            ->exists(['jobType' => ['in', $jobTypeIds], 'assignee' => $assigneeId, 'customer' => $customerId]);
    }
}