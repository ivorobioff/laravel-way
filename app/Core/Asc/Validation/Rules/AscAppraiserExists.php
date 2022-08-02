<?php
namespace RealEstate\Core\Asc\Validation\Rules;

use Restate\Libraries\Validation\Error;
use Restate\Libraries\Validation\Rules\AbstractRule;
use Restate\Libraries\Validation\Value;
use RealEstate\Core\Asc\Services\AscService;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class AscAppraiserExists extends AbstractRule
{
	/**
	 * @var AscService $ascService
	 */
	private $ascService;

	/**
	 * @param AscService $ascService
	 */
	public function __construct(AscService $ascService)
	{
		$this->ascService = $ascService;

		$this->setIdentifier('exists');
		$this->setMessage('The provided appraiser does not exist in the asc database.');
	}

	/**
	 * @param mixed|Value $value
	 * @return Error|null
	 */
	public function check($value)
	{
		if (!$this->ascService->exists($value)){
			return $this->getError();
		}

		return null;
	}
}