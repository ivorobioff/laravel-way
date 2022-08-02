<?php
namespace RealEstate\Api\Shared\Protectors;

use Illuminate\Container\Container;
use RealEstate\Core\Session\Entities\Session;
use Restate\Libraries\Permissions\ProtectorInterface;
use DateTime;

/**
 *
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class AuthProtector implements ProtectorInterface
{
	/**
	 * @var Container
	 */
	protected $container;

	/**
	 * @param Container $container
	 */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * @return bool
     */
    public function grants()
    {
		/**
		 * @var Session $session
		 */
        $session = $this->container->make(Session::class);

        return $session->getId() !== null && $session->getExpireAt() > new DateTime();
    }
}