<?php
namespace RealEstate\Api\User\V2_0\Routes;

use Restate\Libraries\Routing\Router;
use Restate\Libraries\Routing\RouteRegistrarInterface;
use Illuminate\Contracts\Routing\Registrar as RegistrarInterface;
use RealEstate\Api\User\V2_0\Controllers\UsersController;
use RealEstate\Core\User\Validation\Rules\Username;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class Users implements RouteRegistrarInterface
{
	/**
	 * @param RegistrarInterface|Router $registrar
	 */
	public function register(RegistrarInterface $registrar)
	{
		$registrar
			->get('users/{username}', UsersController::class.'@show')
			->where('username', Username::ALLOWED_CHARACTERS);
	}
}