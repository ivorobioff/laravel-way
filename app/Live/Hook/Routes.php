<?php
namespace RealEstate\Live\Hook;

use Illuminate\Routing\Router;
use RealEstate\Support\Shortcut;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class Routes
{
	/**
	 * @param Router $router
	 */
	public function register(Router $router)
	{
		$router->group(['middleware' => 'cors'], function(Router $router){
			$router->post(Shortcut::prependGlobalRoutePrefix('live/auth'), Controller::class.'@auth');
		});
	}
}