<?php
namespace RealEstate\Live\Support;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
interface HandlerInterface
{
	/**
	 * @param object $notification
	 * @return Event
	 */
	public function handle($notification);
}