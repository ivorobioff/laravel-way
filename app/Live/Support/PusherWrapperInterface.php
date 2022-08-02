<?php
namespace RealEstate\Live\Support;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
interface PusherWrapperInterface
{
	/**
	 * @param array $channels
	 * @param $event
	 * @param array $data
	 * @return bool
	 */
	public function trigger(array $channels, $event, array $data);

	/**
	 * @param string $channel
	 * @param string $socket
	 * @return string
	 */
	public function auth($channel, $socket);
}