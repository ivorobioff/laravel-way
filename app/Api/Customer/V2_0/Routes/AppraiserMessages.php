<?php
namespace RealEstate\Api\Customer\V2_0\Routes;
use Restate\Libraries\Routing\RouteRegistrarInterface;
use Illuminate\Contracts\Routing\Registrar as RegistrarInterface;
use RealEstate\Api\Customer\V2_0\Controllers\AppraiserMessagesController;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class AppraiserMessages implements RouteRegistrarInterface
{
    /**
     * @param RegistrarInterface $registrar
     */
    public function register(RegistrarInterface $registrar)
    {
        $registrar->get('customers/{customerId}/appraisers/{appraiserId}/messages', AppraiserMessagesController::class.'@index');
        $registrar->get('customers/{customerId}/appraisers/{appraiserId}/messages/total', AppraiserMessagesController::class.'@total');
    }
}