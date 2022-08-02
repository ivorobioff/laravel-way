<?php
namespace RealEstate\Push\Support;
use RealEstate\Core\Appraisal\Notifications\CreateOrderNotification;
use RealEstate\Core\Customer\Entities\Customer;
use RealEstate\Core\Session\Entities\Session;
use RealEstate\Support\AfterPartyMiddleware;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class AmcNotifier extends AbstractNotifier
{
    /**
     * @param object $notification
     */
    public function notify($notification)
    {
        /**
         * @var Session $session
         */
        $session = $this->container->make(Session::class);

        if (!$session->getUser() instanceof Customer){
            return ;
        }

        $handlers = $this->container->make('config')->get('alert.push.handlers.amc', []);

        if ($notification instanceof CreateOrderNotification && app()->environment() !== 'tests'){

            $this->container->make(AfterPartyMiddleware::class)->schedule(function() use ($notification, $handlers){
                sleep(1);
                $this->forward($notification, $handlers);
            });
        } else {
            $this->forward($notification, $handlers);
        }
    }
}