<?php
namespace RealEstate\Core\Assignee\Validation\Rules;

use Restate\Libraries\Validation\Error;
use Restate\Libraries\Validation\Rules\AbstractRule;
use Restate\Libraries\Validation\Rules\Walk;
use Restate\Libraries\Validation\Value;
use RealEstate\Core\Assignee\Interfaces\CoveragePersistableInterface;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class WalkWithState extends AbstractRule
{
	/**
	 * @var Walk
	 */
	private $walk;

	/**
	 * @param callable $inflator
	 */
	public function __construct(callable  $inflator)
	{
		$this->walk = new Walk($inflator);
	}

	/**
	 * @return Error
	 */
	public function getError()
	{
		return $this->walk->getError();
	}

	/**
	 * @param mixed|Value $value
	 * @return Error|null
	 */
	public function check($value)
	{
		/**
		 * @var CoveragePersistableInterface[] $coverages
		 */
		list($coverages, $state) = $value->extract();

		$data = [];

		foreach ($coverages as $coverage){
			$data[] = [
				'zips' => $coverage->getZips(),
				'county' => $coverage->getCounty(),
				'state' => $state
			];
		}

		$error = $this->walk->check($data);

		if ($error){
			return $this->getError();
		}

		return null;
	}
}