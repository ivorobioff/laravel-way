<?php
namespace RealEstate\Debug\Support;

use Restate\QA\Support\Browser;
use Restate\QA\Support\Request;
use Illuminate\Contracts\Container\Container;
use RealEstate\Live\Support\PusherWrapperInterface;


/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class PusherWrapper implements PusherWrapperInterface
{
	/**
	 * @var Container $container
	 */
	private $container;

	/**
	 * @param Container $container
	 */
	public function __construct(Container $container)
	{
		$this->container = $container;
	}

	/**
	 * @param array $channels
	 * @param $event
	 * @param array $data
	 * @return bool
	 */
	public function trigger(array $channels, $event, array $data)
	{
		$url = $this->container->make('config')->get('app.url');

		$browser = new Browser($url);

		$request = Request::post('/debug/live', ['channels' => $channels, 'event' => $event, 'data' => $data]);

		$browser->send($request);

		return true;
	}

	/**
	 * @param string $channel
	 * @param string $socket
	 * @return string
	 */
	public function auth($channel, $socket)
	{
		return json_encode(['auth' => $channel.':'.$socket]);
	}
}