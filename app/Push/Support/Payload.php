<?php
namespace RealEstate\Push\Support;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class Payload
{
	/**
	 * @var Call[]
	 */
	private $calls;

	/**
	 * @var array
	 */
	private $data;

	/**
	 * @param Call[] $calls
	 * @param array $data
	 */
	public function __construct(array $calls, array $data)
	{
		$this->calls = $calls;
		$this->data = $data;
	}

	/**
	 * @return Call[]
	 */
	public function getCalls()
	{
		return $this->calls;
	}

	/**
	 * @return array
	 */
	public function getData()
	{
		return $this->data;
	}
}