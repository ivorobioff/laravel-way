<?php
namespace RealEstate\Core\Location\Validation\Rules;

use Restate\Libraries\Validation\Error;
use Restate\Libraries\Validation\Rules\AbstractRule;
use Restate\Libraries\Validation\Value;
use RealEstate\Core\Location\Services\CountyService;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class ZipExistsInCounty extends AbstractRule
{
	/**
	 * @var CountyService
	 */
	private $countyService;

	/**
	 * @param CountyService $countyService
	 */
	public function __construct(CountyService $countyService)
	{
		$this->countyService = $countyService;
		$this->setIdentifier('exists');
		$this->setMessage('One or more of the provided zip codes are not found.');
	}

	/**
	 * @param mixed|Value $value
	 * @return Error|null
	 */
	public function check($value)
	{
		list($zips, $county) = $value->extract();

		if (!$this->countyService->hasZips($county, $zips)){
			return $this->getError();
		}

		return null;
	}
}