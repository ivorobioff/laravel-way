<?php
namespace RealEstate\Api\Appraiser\V2_0\Controllers;

use Restate\Libraries\Validation\Error;
use Restate\Libraries\Validation\ErrorsThrowableCollection;
use Illuminate\Http\Response;
use RealEstate\Api\Appraisal\V2_0\Processors\AdditionalDocumentsProcessor;
use RealEstate\Api\Appraisal\V2_0\Processors\AdditionalDocumentsSearchableProcessor;
use RealEstate\Api\Appraisal\V2_0\Transformers\AdditionalDocumentTransformer;
use RealEstate\Api\Appraiser\V2_0\Processors\EmailProcessor;
use RealEstate\Api\Customer\V2_0\Transformers\AdditionalDocumentTypeTransformer;
use RealEstate\Api\Support\BaseController;
use RealEstate\Core\Appraisal\Options\FetchAdditionalDocumentsOptions;
use RealEstate\Core\Appraisal\Services\AdditionalDocumentService;
use RealEstate\Core\Appraisal\Services\OrderService;
use RealEstate\Core\Appraiser\Services\AppraiserService;
use RealEstate\Core\Shared\Exceptions\InvalidEmailException;
use RealEstate\Core\Support\Criteria\Sorting\Direction;
use RealEstate\Core\Support\Criteria\Sorting\Sortable;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class AdditionalDocumentsController extends BaseController
{
	/**
	 * @param AdditionalDocumentService $additionalDocumentService
	 */
	public function initialize(AdditionalDocumentService $additionalDocumentService)
	{
		$this->additionalDocumentService = $additionalDocumentService;
	}

	/**
	 * @var AdditionalDocumentService
	 */
	private $additionalDocumentService;

	/**
	 * @param AdditionalDocumentsSearchableProcessor $processor
	 * @param int $appraiserId
	 * @param int $orderId
	 * @return Response
	 */
	public function index(
		AdditionalDocumentsSearchableProcessor $processor,
		$appraiserId,
		$orderId
	)
	{
		$options = new FetchAdditionalDocumentsOptions();

		$sortables = $processor->createSortables();

		if (!$sortables){
			$sortables[] = new Sortable('createdAt', new Direction(Direction::DESC));
		}

		$options->setSortables($sortables);

		return $this->resource->makeAll(
			$this->additionalDocumentService->getAll($orderId, $options),
			$this->transformer(AdditionalDocumentTransformer::class)
		);
	}

	/**
	 * @param AdditionalDocumentsProcessor $processor
	 * @param int $appraiserId
	 * @param int $orderId
	 * @return Response
	 */
	public function store(AdditionalDocumentsProcessor $processor, $appraiserId, $orderId)
	{
		return $this->resource->make(
			$this->additionalDocumentService->create($orderId, $processor->createPersistable()),
			$this->transformer(AdditionalDocumentTransformer::class)
		);
	}

	/**
	 * @param int $appraiserId
	 * @param int $orderId
	 * @return Response
	 */
	public function types($appraiserId, $orderId)
	{
		return $this->resource->makeAll(
			$this->additionalDocumentService->getTypes($orderId),
			$this->transformer(AdditionalDocumentTypeTransformer::class)
		);
	}

	/**
	 * @param int $appraiserId
	 * @param int $orderId
	 * @param int $documentId
	 * @param EmailProcessor $processor
	 * @return Response
	 * @throws ErrorsThrowableCollection
	 */
	public function email($appraiserId, $orderId, $documentId, EmailProcessor $processor)
	{
		try {
			$this->additionalDocumentService->emailOnAppraiserBehalf($documentId, $processor->getEmail());
		} catch (InvalidEmailException $ex){
			$errors = new ErrorsThrowableCollection();
			$errors['email'] = new Error('format', $errors->getMessage());
			throw $errors;
		}

		return $this->resource->blank();
	}

	/**
	 * @param AppraiserService $appraiserService
	 * @param OrderService $orderService
	 * @param int $appraiserId
	 * @param int $orderId
	 * @param int $documentId
	 * @return bool
	 */
	public static function verifyAction(
		AppraiserService $appraiserService,
		OrderService $orderService,
		$appraiserId,
		$orderId,
		$documentId = null
	)
	{
		if (!$appraiserService->exists($appraiserId)){
			return false;
		}

		if (!$appraiserService->hasOrder($appraiserId, $orderId)){
			return false;
		}

		if ($documentId === null){
			return true;
		}

		return $orderService->hasAdditionalDocument($orderId, $documentId);
	}
}