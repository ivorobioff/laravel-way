<?php
namespace RealEstate\Core\Appraisal\Objects;

use RealEstate\Core\Appraisal\Enums\Queue;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class Counter
{
	/**
	 * @var Queue
	 */
	private $queue;
	public function getQueue() { return $this->queue; }

	/**
	 * @var int
	 */
	private $total;
	public function getTotal() { return $this->total; }

	/**
	 * @param Queue $queue
	 * @param $total
	 */
	public function __construct(Queue $queue, $total)
	{
		$this->queue = $queue;
		$this->total = $total;
	}
}