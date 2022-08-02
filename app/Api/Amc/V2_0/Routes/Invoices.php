<?php
namespace RealEstate\Api\Amc\V2_0\Routes;
use Restate\Libraries\Routing\RouteRegistrarInterface;
use Illuminate\Contracts\Routing\Registrar as RegistrarInterface;
use RealEstate\Api\Amc\V2_0\Controllers\InvoicesController;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class Invoices implements RouteRegistrarInterface
{
    /**
     * @param RegistrarInterface $registrar
     */
    public function register(RegistrarInterface $registrar)
    {
        $registrar->get('amcs/{amcId}/invoices', InvoicesController::class.'@index');
        $registrar->post('amcs/{amcId}/invoices/{invoiceId}/pay', InvoicesController::class.'@pay');
    }
}