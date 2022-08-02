<?php
namespace RealEstate\Core\Shared\Interfaces;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
interface NotifierInterface
{
	/**
	 * @param object $notification
	 */
	public function notify($notification);
}