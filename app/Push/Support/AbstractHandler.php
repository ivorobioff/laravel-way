<?php
namespace RealEstate\Push\Support;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
abstract class AbstractHandler implements HandlerInterface
{
	/**
	 * @param object $notification
	 * @return Payload
	 */
	public function handle($notification)
	{
		$calls = $this->getCalls($notification);

		if (!$calls){
			return null;
		}

		return new Payload($calls, $this->transform($notification));
	}

	/**
	 * @param object $notification
	 * @return Call[]
	 */
	protected abstract function getCalls($notification);

	/**
	 * @param object $notification
	 * @return array
	 */
	protected abstract function transform($notification);
}