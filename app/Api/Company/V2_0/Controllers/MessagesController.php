<?php
namespace RealEstate\Api\Company\V2_0\Controllers;
use Restate\Libraries\Verifier\Action;
use Illuminate\Http\Response;
use RealEstate\Api\Appraisal\V2_0\Processors\MessagesProcessor;
use RealEstate\Api\Appraisal\V2_0\Processors\MessagesSearchableProcessor;
use RealEstate\Api\Appraisal\V2_0\Processors\SelectedMessagesProcessor;
use RealEstate\Api\Appraisal\V2_0\Support\MessagesTrait;
use RealEstate\Api\Appraisal\V2_0\Transformers\MessageTransformer;
use RealEstate\Api\Support\BaseController;
use RealEstate\Api\Support\DefaultPaginatorAdapter;
use RealEstate\Core\Appraisal\Options\FetchMessagesOptions;
use RealEstate\Core\Appraisal\Services\MessageService;
use RealEstate\Core\Company\Services\ManagerService;
use RealEstate\Core\Shared\Options\PaginationOptions;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class MessagesController extends BaseController
{
    use MessagesTrait;

    /**
     * @var MessageService
     */
    private $messageService;

    /**
     * @param MessageService $messageService
     */
    public function initialize(MessageService $messageService)
    {
        $this->messageService = $messageService;
    }

    /**
     * @param MessagesSearchableProcessor $processor
     * @param int $managerId
     * @return Response
     */
    public function index(MessagesSearchableProcessor $processor, $managerId)
    {
        $adapter = new DefaultPaginatorAdapter([
            'getAll' => function($page, $perPage) use ($managerId, $processor){
                $options = new FetchMessagesOptions();
                $options->setPagination(new PaginationOptions($page, $perPage));
                $options->setSortables($processor->createSortables());
                $options->setCriteria($processor->getCriteria());

                return $this->messageService->getAllByParticipantId($managerId, $options);
            },
            'getTotal' => function() use ($managerId, $processor){
                return $this->messageService->getTotalByParticipantId($managerId, $processor->getCriteria());
            }
        ]);

        return $this->resource->makeAll(
            $this->paginator($adapter),
            $this->transformer(MessageTransformer::class)
        );
    }

    /**
     * @param MessagesSearchableProcessor $processor
     * @param int $managerId
     * @param int $orderId
     * @return Response
     */
    public function indexByOrder(MessagesSearchableProcessor $processor, $managerId, $orderId)
    {
        $adapter = new DefaultPaginatorAdapter([
            'getAll' => function($page, $perPage) use ($orderId, $processor){
                $options = new FetchMessagesOptions();
                $options->setPagination(new PaginationOptions($page, $perPage));
                $options->setSortables($processor->createSortables());
                $options->setCriteria($processor->getCriteria());

                return $this->messageService->getAllByOrderId($orderId, $options);
            },
            'getTotal' => function() use ($orderId, $processor){
                return $this->messageService->getTotalByOrderId($orderId, $processor->getCriteria());
            }
        ]);

        return $this->resource->makeAll(
            $this->paginator($adapter),
            $this->transformer(MessageTransformer::class)
        );
    }

    /**
     * @param int $managerId
     * @return Response
     */
    public function markAllAsRead($managerId)
    {
        $this->messageService->markAllAsRead($managerId);

        return $this->resource->blank();
    }

    /**
     * @param int $managerId
     * @param int $messageId
     * @return Response
     */
    public function markAsRead($managerId, $messageId)
    {
        $this->tryMarkAsRead(function() use ($messageId, $managerId){
            $this->messageService->markAsRead([$messageId], $managerId);
        });

        return $this->resource->blank();
    }

    /**
     * @param SelectedMessagesProcessor $processor
     * @param int $managerId
     * @return Response
     */
    public function markSomeAsRead(SelectedMessagesProcessor $processor, $managerId)
    {
        $this->tryMarkAsRead(function() use ($processor, $managerId){
            $this->messageService->markAsRead($processor->getMessages(), $managerId);
        });

        return $this->resource->blank();
    }

    /**
     * @param int $managerId
     * @param int $messageId
     * @return Response
     */
    public function show($managerId, $messageId)
    {
        return $this->resource->make(
            $this->messageService->get($messageId),
            $this->transformer(MessageTransformer::class)
        );
    }

    /**
     * @param int $managerId
     * @param int $orderId
     * @param MessagesProcessor $processor
     * @return Response
     */
    public function store($managerId, $orderId, MessagesProcessor $processor)
    {
        return $this->resource->make(
            $this->messageService->create($managerId, $orderId, $processor->createPersistable()),
            $this->transformer(MessageTransformer::class)
        );
    }


    /**
     * @param int $managerId
     * @return Response
     */
    public function total($managerId)
    {
        return $this->resource->make([
            'total' => $this->messageService->getTotalByParticipantId($managerId),
            'unread' => $this->messageService->getTotalUnreadByParticipantId($managerId)
        ]);
    }

    /**
     * @param Action $action
     * @param ManagerService $managerService
     * @param MessageService $messageService
     * @param int $managerId
     * @param int $orderOrMessageId
     * @return bool
     */
    public static function verifyAction(
        Action $action,
        ManagerService $managerService,
        MessageService $messageService,
        $managerId,
        $orderOrMessageId = null
    )
    {
        if (!$managerService->exists($managerId)){
            return false;
        }

        if ($action->is(['store', 'indexByOrder'])){
            return $managerService->hasOrder($managerId, $orderOrMessageId);
        }

        if ($orderOrMessageId === null){
            return true;
        }

        return $messageService->isReadableByParticipantId($orderOrMessageId, $managerId);
    }
}