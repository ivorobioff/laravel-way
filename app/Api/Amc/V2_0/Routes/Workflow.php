<?php
namespace RealEstate\Api\Amc\V2_0\Routes;

use Restate\Libraries\Routing\RouteRegistrarInterface;
use Illuminate\Contracts\Routing\Registrar as RegistrarInterface;
use RealEstate\Api\Amc\V2_0\Controllers\WorkflowController;
use RealEstate\Core\Appraisal\Enums\ProcessStatus;

class Workflow implements RouteRegistrarInterface
{
    /**
     * @param RegistrarInterface $registrar
     */
    public function register(RegistrarInterface $registrar)
    {
        $values = ProcessStatus::toArray();

        foreach ($values as $value){
            $registrar->post(
                'amcs/{amcId}/orders/{ordersId}/workflow/'.$value,
                WorkflowController::class.'@'.camel_case($value === 'new' ? 'fresh' : $value)
            );

            $registrar->post(
                '/amcs/{amcId}/orders/{ordersId}/workflow/resume',
                WorkflowController::class.'@resume'
            );
        }
    }
}
