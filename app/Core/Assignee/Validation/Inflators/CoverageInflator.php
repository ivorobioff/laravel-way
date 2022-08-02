<?php
namespace RealEstate\Core\Assignee\Validation\Inflators;

use Restate\Libraries\Validation\Binder;
use Restate\Libraries\Validation\Property;
use Restate\Libraries\Validation\Rules\Obligate;
use Restate\Libraries\Validation\SourceHandlerInterface;
use RealEstate\Core\Location\Services\CountyService;
use RealEstate\Core\Location\Services\StateService;
use RealEstate\Core\Location\Validation\Rules\CountyExistsInState;
use RealEstate\Core\Location\Validation\Rules\ZipExistsInCounty;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class CoverageInflator
{
	/**
	 * @var StateService
	 */
	private $stateService;

	/**
	 * @var CountyService
	 */
	private $countyService;

	/**
	 * @param StateService $stateService
	 * @param CountyService $countyService
	 */
	public function __construct(StateService $stateService, CountyService $countyService)
	{
		$this->stateService = $stateService;
		$this->countyService = $countyService;
	}

	/**
	 * @param Binder $binder
	 */
	public function __invoke(Binder $binder)
	{
		$binder->bind('county', ['county', 'state'], function(Property $property){
			$property
				->addRule(new Obligate())
				->addRule(new CountyExistsInState($this->stateService));
		});

		$binder->bind('zips', ['zips', 'county'], function(Property $property){
			$property
				->addRule(new ZipExistsInCounty($this->countyService));
		})->when(function(SourceHandlerInterface $source){
			return (bool) $source->getValue('zips');
		});
	}
}