<?php
namespace RealEstate\Mobile\Support;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
interface HandlerInterface
{
	/**
	 * @param object $notification
	 * @return Tuple
	 */
	public function handle($notification);
}