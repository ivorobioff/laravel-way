<?php
namespace RealEstate\Api\Shared\Protectors;

use Restate\Libraries\Permissions\OptionsExpectableInterface;
use Restate\Libraries\Permissions\OptionsExpectableTrait;
use Illuminate\Http\Request;
use RealEstate\Core\Session\Entities\Session;

/**
 *
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class OwnerProtector extends AuthProtector implements OptionsExpectableInterface
{
    use OptionsExpectableTrait;

    /**
     * @return bool
     */
    public function grants()
    {
        if (! parent::grants()) {
            return false;
        }

		/**
		 * @var Session $session
		 */
		$session = $this->container->make(Session::class);

        return $session->getUser()->getId() == $this->getOwnerId();
    }

    /**
     *
     * @return int|null
     */
    protected function getOwnerId()
    {
		/**
		 * @var Request $request
		 */
		$request = $this->container->make('request');

        $parameters = array_values($request->route()->parameters());

        $index = array_take($this->getOptions(), 'index', 0);

        return $parameters[$index];
    }
}