<?php
namespace RealEstate\Api\Company\V2_0\Transformers;
use RealEstate\Core\Company\Entities\Company;
use RealEstate\Core\Company\Entities\Staff;
use RealEstate\Core\Company\Services\StaffService;
use RealEstate\Core\Session\Entities\Session;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class StaffCalculatedProperty
{
    /**
     * @var StaffService
     */
    private $staffService;

    /**
     * @var Session
     */
    private $session;

    /**
     * @param StaffService $staffService
     * @param Session $session
     */
    public function __construct(StaffService $staffService, Session $session)
    {
        $this->staffService = $staffService;
        $this->session = $session;
    }

    /**
     * @param Company $company
     * @return Staff
     */
    public function __invoke(Company $company)
    {
        return $this->staffService->getByCompanyAndUserIds($company->getId(), $this->session->getUser()->getId());
    }
}