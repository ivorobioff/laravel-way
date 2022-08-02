<?php
namespace RealEstate\Live\Hook;

use Restate\Libraries\Permissions\PermissionsManager;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;
use RealEstate\Live\Support\PusherWrapperInterface;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class Controller extends BaseController
{
	/**
	 * @param Request $request
	 * @param PusherWrapperInterface $pusher
	 * @param PermissionsManager $permissions
	 * @return Response
	 */
	public function auth(Request $request, PusherWrapperInterface $pusher, PermissionsManager $permissions)
	{
		$header = ['Content-Type' => 'application/json'];

		if (!$permissions->has(Protector::class)){
			return new Response('', Response::HTTP_FORBIDDEN, $header);
		}

		$content = $pusher->auth($request->input('channel_name'), $request->input('socket_id'));

		return new Response($content, Response::HTTP_OK, $header);
	}
}