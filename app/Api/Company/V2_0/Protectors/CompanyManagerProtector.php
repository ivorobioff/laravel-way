<?php
namespace RealEstate\Api\Company\V2_0\Protectors;

use Illuminate\Http\Request;
use RealEstate\Api\Shared\Protectors\AuthProtector;
use RealEstate\Core\Company\Services\CompanyService;
use RealEstate\Core\Session\Entities\Session;

class CompanyManagerProtector extends AuthProtector
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

        $companyId = $request->route()->parameter('companyId');

        $session = $this->container->make(Session::class);

        $companyService = $this->container->make(CompanyService::class);

        return $companyService->hasManager($companyId, $session->getUser()->getId());
    }
}
