<?php
namespace RealEstate\Api\Session\V2_0\Protectors;

use RealEstate\Api\Shared\Protectors\AuthProtector;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use RealEstate\Core\Session\Entities\Session;
use RealEstate\Core\Session\Services\SessionService;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class SessionProtector extends AuthProtector
{
	/**
     * @return bool
     */
    public function grants()
    {
        if (! parent::grants()) {
            return false;
        }

		/**
		 * @var Request $request
		 */
		$request = $this->container->make('request');

        /**
         * @var Route $route
         */
        $route = $request->route();

        $sessionId = array_take(array_values($route->parameters()), 0);

        if ($sessionId === null) {

            if (strtolower($request->method()) === strtolower(Request::METHOD_DELETE)) {
                $userId = $request->query->get('user');

                if (! $userId) {
                    return false;
                }

                return $this->getUserId() == $userId;
            }

            return false;
        }

		/**
		 * @var SessionService $sessionService
		 */
		$sessionService = $this->container->make(SessionService::class);

        return $sessionService->verifyOwner($sessionId, $this->getUserId());
    }

    /**
     * @return int
     */
    private function getUserId()
    {
		/**
		 * @var Session $session
		 */
		$session = $this->container->make(Session::class);

        return $session->getUser()->getId();
    }
}