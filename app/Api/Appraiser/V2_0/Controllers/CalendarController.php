<?php
namespace RealEstate\Api\Appraiser\V2_0\Controllers;

use Illuminate\Http\Response;
use RealEstate\Api\Appraiser\V2_0\Processors\CalendarSearchableProcessor;
use RealEstate\Api\Appraiser\V2_0\Transformers\BadgeTransformer;
use RealEstate\Api\Support\BaseController;
use RealEstate\Core\Appraisal\Services\CalendarService;
use RealEstate\Core\Appraiser\Services\AppraiserService;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class CalendarController extends BaseController
{
	/**
	 * @var CalendarService
	 */
	private $calendarService;

	/**
	 * @param CalendarService $calendarService
	 */
	public function initialize(CalendarService $calendarService)
	{
		$this->calendarService = $calendarService;
	}

	/**
	 * @param int $appraiserId
	 * @param CalendarSearchableProcessor $processor
	 * @return Response
	 */
	public function day($appraiserId, CalendarSearchableProcessor $processor)
	{
		return $this->resource->makeAll(
			$this->calendarService->getAllBadgesWithDayScale($appraiserId, $processor->getFrom(), $processor->getTo()),
			$this->transformer(BadgeTransformer::class)
		);
	}

	/**
	 * @param AppraiserService $appraiserService
	 * @param int $appraiserId
	 * @return bool
	 */
	public static function verifyAction(AppraiserService $appraiserService, $appraiserId)
	{
		return $appraiserService->exists($appraiserId);
	}
}