<?php
namespace RealEstate\Api\Company\V2_0\Controllers;
use Restate\Libraries\Verifier\Action;
use Illuminate\Http\Response;
use RealEstate\Api\Appraisal\V2_0\Processors\DocumentsProcessor;
use RealEstate\Api\Appraisal\V2_0\Support\DocumentsTrait;
use RealEstate\Api\Appraisal\V2_0\Transformers\DocumentTransformer;
use RealEstate\Api\Assignee\V2_0\Transformers\DocumentSupportedFormatsTransformer;
use RealEstate\Api\Support\BaseController;
use RealEstate\Core\Appraisal\Services\DocumentService;
use RealEstate\Core\Appraisal\Services\OrderService;
use RealEstate\Core\Company\Services\ManagerService;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class DocumentController extends BaseController
{
    use DocumentsTrait;

    /**
     * @var DocumentService
     */
    private $documentService;

    /**
     * @var OrderService
     */
    private $orderService;

    /**
     * @param DocumentService $documentService
     * @param OrderService $orderService
     */
    public function initialize(
        DocumentService $documentService,
        OrderService $orderService
    )
    {
        $this->documentService = $documentService;
        $this->orderService = $orderService;
    }

    /**
     * @param int $managerId
     * @param int $orderId
     * @param DocumentsProcessor $processor
     * @return Response
     */
    public function store($managerId, $orderId, DocumentsProcessor $processor)
    {
        return $this->resource->make($this->tryCreate(function() use ($orderId, $processor){
            return $this->orderService->proceedWithDocument($orderId, $processor->createPersistable());
        }), $this->transformer(DocumentTransformer::class));
    }

    /**
     * @param int $managerId
     * @param int $orderId
     * @param DocumentsProcessor $processor
     * @return Response
     */
    public function update($managerId, $orderId, DocumentsProcessor $processor)
    {
        $this->documentService->updateRecent($orderId, $processor->createPersistable());

        return $this->resource->blank();
    }

    /**
     * @param $managerId
     * @param $orderId
     * @return Response
     */
    public function show($managerId, $orderId)
    {
        return $this->resource->make(
            $this->documentService->getRecent($orderId),
            $this->transformer(DocumentTransformer::class)
        );
    }

    /**
     * @param int $managerId
     * @param int $orderId
     * @return Response
     */
    public function formats($managerId, $orderId)
    {
        return $this->resource->make(
            $this->documentService->getSupportedFormats($orderId),
            $this->transformer(DocumentSupportedFormatsTransformer::class)
        );
    }

    /**
     * @param Action $action
     * @param ManagerService $managerService
     * @param DocumentService $documentService
     * @param int $managerId
     * @param int $orderId
     * @return bool
     */
    public static function verifyAction(
        Action $action,
        ManagerService $managerService,
        DocumentService  $documentService,
        $managerId,
        $orderId
    )
    {
        if (!$managerService->exists($managerId)){
            return false;
        }

        if (!$managerService->hasOrder($managerId, $orderId)){
            return false;
        }

        if ($action->is(['store', 'formats'])){
            return true;
        }

        return $documentService->existsRecent($orderId);
    }
}