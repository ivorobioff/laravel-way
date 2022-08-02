<?php
namespace RealEstate\Api\Amc\V2_0\Routes;
use Restate\Libraries\Routing\RouteRegistrarInterface;
use Illuminate\Contracts\Routing\Registrar as RegistrarInterface;
use RealEstate\Api\Amc\V2_0\Controllers\RevisionsController;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class Revisions implements RouteRegistrarInterface
{
    /**
     * @param RegistrarInterface $registrar
     */
    public function register(RegistrarInterface $registrar)
    {
        $registrar->resource('amcs.orders.revisions', RevisionsController::class, ['only' => ['index']]);

        $registrar->get('amcs/{amcId}/revisions/{revisionId}', RevisionsController::class.'@show');
        $registrar->get('amcs/{amcId}/orders/{orderId}/revisions/{revisionId}', RevisionsController::class.'@showByOrder');
    }
}