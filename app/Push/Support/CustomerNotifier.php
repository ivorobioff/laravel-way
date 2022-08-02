<?php
namespace RealEstate\Push\Support;

use Symfony\Component\HttpKernel\Exception\ServiceUnavailableHttpException;
use RealEstate\Core\Customer\Entities\Customer;
use RealEstate\Core\Session\Entities\Session;


/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class CustomerNotifier extends AbstractNotifier
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

		if ($session->getUser() instanceof Customer){
			return ;
		}

		if ($this->environment->isRelaxed()){
			return ;
		}

		$handlers = $this->container->make('config')->get('alert.push.handlers.customer', []);

        $this->forward($notification, $handlers, function(array $call, array $data){
            if ($data['type'] === 'order' && $data['event'] === 'create-document'){
                throw new ServiceUnavailableHttpException(null, 'Unable to send the document to the customer');
            }
        });
	}
}