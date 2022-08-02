<?php
namespace RealEstate\Live\Support;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Routing\Router;
use RealEstate\Live\Hook\Routes;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class RouteServiceProvider extends ServiceProvider
{
	/**
	 * @param Router $router
	 */
	public function map(Router $router)
	{
		(new Routes())->register($router);
	}
}