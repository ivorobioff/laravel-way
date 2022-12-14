<?php
namespace RealEstate\Api\Company\V2_0\Protectors;
use Illuminate\Http\Request;
use RealEstate\Api\Shared\Protectors\AuthProtector;
use RealEstate\Core\Company\Services\CompanyService;
use RealEstate\Core\Company\Services\ManagerService;
use RealEstate\Core\Session\Entities\Session;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class AdminForManagerProtector extends AuthProtector
{
    /**
     * @return bool
     */
    public function grants()
    {
        if (!parent::grants()) {
            return false;
        }

        /**
         * @var Request $request
         */
        $request = $this->container->make('request');

        $managerId = array_values($request->route()->parameters())[0];

        /**
         * @var ManagerService $managerService
         */
        $managerService = $this->container->make(ManagerService::class);

        $manager = $managerService->get($managerId);

        if (!$manager){
            return false;
        }

        $company = $manager->getStaff()->getCompany();

        /**
         * @var Session $session
         */
        $session = $this->container->make(Session::class);

        /**
         * @var CompanyService $companyService
         */
        $companyService = $this->container->make(CompanyService::class);

        return $companyService->hasAdmin($company->getId(), $session->getUser()->getId());
    }
}