<?php
namespace RealEstate\Api\Customer\V2_0\Controllers;

use Illuminate\Http\Response;
use RealEstate\Api\Appraisal\V2_0\Processors\AdditionalDocumentsProcessor;
use RealEstate\Api\Appraisal\V2_0\Processors\AdditionalDocumentsSearchableProcessor;
use RealEstate\Api\Appraisal\V2_0\Transformers\AdditionalDocumentTransformer;
use RealEstate\Api\Support\BaseController;
use RealEstate\Core\Appraisal\Options\FetchAdditionalDocumentsOptions;
use RealEstate\Core\Appraisal\Services\AdditionalDocumentService;
use RealEstate\Core\Appraisal\Services\OrderService;
use RealEstate\Core\Customer\Services\CustomerService;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class AdditionalDocumentsController extends BaseController
{
	/**
	 * @var AdditionalDocumentService
	 */
	private $additionalDocumentService;

	/**
	 * @param AdditionalDocumentService $additionalDocumentService
	 */
	public function initialize(AdditionalDocumentService $additionalDocumentService)
	{
		$this->additionalDocumentService = $additionalDocumentService;
	}

	/**
	 * @param AdditionalDocumentsSearchableProcessor $processor
	 * @param int $customerId
	 * @param int $orderId
	 * @return Response
	 */
	public function index(
		AdditionalDocumentsSearchableProcessor $processor,
		$customerId,
		$orderId
	)
	{
		$options = new FetchAdditionalDocumentsOptions();
		$options->setSortables($processor->createSortables());

		return $this->resource->makeAll(
			$this->additionalDocumentService->getAll($orderId, $options),
			$this->transformer(AdditionalDocumentTransformer::class)
		);
	}

	/**
	 * @param AdditionalDocumentsProcessor $processor
	 * @param int $customerId
	 * @param int $orderId
	 * @return Response
	 */
	public function store(AdditionalDocumentsProcessor $processor, $customerId, $orderId)
	{
		return $this->resource->make(
			$this->additionalDocumentService->create($orderId, $processor->createPersistable()),
			$this->transformer(AdditionalDocumentTransformer::class)
		);
	}

	/**
	 * @param int $customerId
	 * @param int $orderId
	 * @param int $documentId
	 * @return Response
	 */
	public function show($customerId, $orderId, $documentId)
	{
		return $this->resource->make(
			$this->additionalDocumentService->get($documentId),
			$this->transformer(AdditionalDocumentTransformer::class)
		);
	}

	/**
	 * @param int $customerId
	 * @param int $orderId
	 * @param int $documentId
	 * @return Response
	 */
	public function destroy($customerId, $orderId, $documentId)
	{
		$this->additionalDocumentService->delete($documentId);

		return $this->resource->blank();
	}

	/**
	 * @param CustomerService $customerService
	 * @param OrderService $orderService
	 * @param int $customerId
	 * @param int $orderId
	 * @param int $documentId
	 * @return bool
	 */
	public static function verifyAction(
		CustomerService $customerService,
		OrderService $orderService,
		$customerId,
		$orderId,
		$documentId = null
	)
	{
		if (!$customerService->exists($customerId)){
			return false;
		}

		if (!$customerService->hasOrder($customerId, $orderId)){
			return false;
		}

		if ($documentId === null){
			return true;
		}

		return $orderService->hasAdditionalDocument($orderId, $documentId);
	}
}