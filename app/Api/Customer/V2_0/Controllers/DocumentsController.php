<?php
namespace RealEstate\Api\Customer\V2_0\Controllers;

use Illuminate\Http\Response;
use RealEstate\Api\Appraisal\V2_0\Processors\DocumentsProcessor;
use RealEstate\Api\Appraisal\V2_0\Support\DocumentsTrait;
use RealEstate\Api\Appraisal\V2_0\Transformers\DocumentTransformer;
use RealEstate\Api\Support\BaseController;
use RealEstate\Core\Appraisal\Options\CreateDocumentOptions;
use RealEstate\Core\Appraisal\Options\UpdateDocumentOptions;
use RealEstate\Core\Appraisal\Services\DocumentService;
use RealEstate\Core\Appraisal\Services\OrderService;
use RealEstate\Core\Customer\Services\CustomerService;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class DocumentsController extends BaseController
{
	use DocumentsTrait;
	
	/**
	 * @var DocumentService
	 */
	private $documentService;

	/**
	 * @param DocumentService $documentService
	 */
	public function initialize(DocumentService $documentService)
	{
		$this->documentService = $documentService;
	}

	/**
	 * @param int $customerId
	 * @param int $orderId
	 * @return Response
	 */
	public function index($customerId, $orderId)
	{
		return $this->resource->makeAll(
			$this->documentService->getAll($orderId),
			$this->transformer(DocumentTransformer::class)
		);
	}

	/**
	 * @param int $customerId
	 * @param int $orderId
	 * @param DocumentsProcessor $processor
	 * @return Response
	 */
	public function store($customerId, $orderId, DocumentsProcessor $processor)
	{
		return $this->resource->make($this->tryCreate(function() use ($orderId, $processor){
			$options = new CreateDocumentOptions();
			$options->setCheckDocumentSupportedFormats(false);
			return $this->documentService->create($orderId, $processor->createPersistable(), $options);
		}), $this->transformer(DocumentTransformer::class));
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
			$this->documentService->get($documentId),
			$this->transformer(DocumentTransformer::class)
		);
	}

	/**
	 * @param int $customerId
	 * @param int $orderId
	 * @param int $documentId
	 * @param DocumentsProcessor $processor
	 * @return Response
	 */
	public function update($customerId, $orderId, $documentId, DocumentsProcessor $processor)
	{
		$options = new UpdateDocumentOptions();
		$options->setCheckDocumentSupportedFormats(false);

		$this->documentService->update(
			$documentId, $processor->createPersistable(), 
			$processor->schedulePropertiesToClear($options)
		);
		return $this->resource->blank();
	}

	/**
	 * @param int $customerId
	 * @param int $orderId
	 * @param int $documentId
	 * @return Response
	 */
	public function destroy($customerId, $orderId, $documentId)
	{
		$this->documentService->delete($documentId);

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

		return $orderService->hasDocument($orderId, $documentId);
	}
}