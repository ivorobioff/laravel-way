<?php
namespace RealEstate\Push\Support;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
interface HandlerInterface
{
	/**
	 * @param object $notification
	 * @return Payload
	 */
	public function handle($notification);
}