<?php
namespace RealEstate\Api\Amc\V2_0\Routes;
use Restate\Libraries\Routing\RouteRegistrarInterface;
use Illuminate\Contracts\Routing\Registrar as RegistrarInterface;
use RealEstate\Api\Amc\V2_0\Controllers\AdditionalDocumentsController;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class AdditionalDocuments implements RouteRegistrarInterface
{
    /**
     * @param RegistrarInterface $registrar
     */
    public function register(RegistrarInterface $registrar)
    {
        $registrar->resource('amcs.orders.additional-documents', AdditionalDocumentsController::class, [
            'only' => ['index', 'store']
        ]);

        $registrar->get(
            'amcs/{amcId}/orders/{orderId}/additional-documents/types',
            AdditionalDocumentsController::class.'@types'
        );
    }
}