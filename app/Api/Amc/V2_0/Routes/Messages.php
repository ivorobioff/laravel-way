<?php
namespace RealEstate\Api\Amc\V2_0\Routes;
use Restate\Libraries\Routing\RouteRegistrarInterface;
use Illuminate\Contracts\Routing\Registrar as RegistrarInterface;
use RealEstate\Api\Amc\V2_0\Controllers\MessagesController;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class Messages implements RouteRegistrarInterface
{
    /**
     * @param RegistrarInterface $registrar
     */
    public function register(RegistrarInterface $registrar)
    {
        $registrar->get(
            'amcs/{amcId}/orders/{orderId}/messages',
            MessagesController::class.'@indexByOrder'
        );

        $registrar->post(
            'amcs/{amcId}/orders/{orderId}/messages',
            MessagesController::class.'@store'
        );

        $registrar->get(
            'amcs/{amcId}/messages',
            MessagesController::class.'@index'
        );

        $registrar->get(
            'amcs/{amcId}/messages/{messageId}',
            MessagesController::class.'@show'
        );

        $registrar->post(
            'amcs/{amcId}/messages/{messageId}/mark-as-read',
            MessagesController::class.'@markAsRead'
        );

        $registrar->post(
            'amcs/{amcId}/messages/mark-all-as-read',
            MessagesController::class.'@markAllAsRead'
        );

        $registrar->post(
            'amcs/{amcId}/messages/mark-as-read',
            MessagesController::class.'@markSomeAsRead'
        );

        $registrar->get(
            'amcs/{amcId}/messages/total',
            MessagesController::class.'@total'
        );
    }
}