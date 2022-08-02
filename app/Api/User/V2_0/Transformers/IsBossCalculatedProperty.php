<?php
namespace RealEstate\Api\User\V2_0\Transformers;
use RealEstate\Core\Company\Services\StaffService;
use RealEstate\Core\User\Entities\User;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class IsBossCalculatedProperty
{
    /**
     * @var StaffService
     */
    private $staffService;

    /**
     * @param StaffService $staffService
     */
    public function __construct(StaffService $staffService)
    {
        $this->staffService = $staffService;
    }

    /**
     * @param User $user
     * @return bool
     */
    public function __invoke(User $user)
    {
        return $this->staffService->isBoss($user->getId());
    }
}