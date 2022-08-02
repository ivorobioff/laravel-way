<?php
namespace RealEstate\Api\Shared\Controllers;

use Illuminate\Routing\Controller;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class DefaultController extends Controller
{
	/**
	 * @return string
	 */
	public function server()
	{
		return 'You\'ve reached the RealEstate API server.';
	}

	/**
	 * @return string
	 */
	public function api()
	{
		return 'You\'ve reached the RealEstate API v2.0 server.';
	}
}