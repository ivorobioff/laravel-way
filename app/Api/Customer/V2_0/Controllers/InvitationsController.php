<?php
namespace RealEstate\Api\Customer\V2_0\Controllers;

use Restate\Libraries\Validation\ErrorsThrowableCollection;
use Illuminate\Http\Response;
use RealEstate\Api\Customer\V2_0\Processors\InvitationsProcessor;
use RealEstate\Api\Invitation\V2_0\Processors\InvitationsSearchableProcessor;
use RealEstate\Api\Invitation\V2_0\Transformers\InvitationTransformer;
use RealEstate\Api\Support\BaseController;
use RealEstate\Api\Support\DefaultPaginatorAdapter;
use RealEstate\Core\Customer\Services\CustomerService;
use RealEstate\Core\Invitation\Options\FetchInvitationsOptions;
use RealEstate\Core\Invitation\Services\InvitationService;
use RealEstate\Core\Shared\Options\PaginationOptions;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class InvitationsController extends BaseController
{
	/**
	 * @var InvitationService
	 */
	private $invitationService;

	/**
	 * @param InvitationService $invitationService
	 */
	public function initialize(InvitationService $invitationService)
	{
		$this->invitationService = $invitationService;
	}

	/**
	 * @param int $customerId
	 * @param InvitationsProcessor $processor
	 * @return Response
	 * @throws  ErrorsThrowableCollection
	 */
	public function store($customerId, InvitationsProcessor $processor)
	{
		return $this->resource->make(
			$this->invitationService->create($customerId, $processor->createPersistable()),
			$this->transformer(InvitationTransformer::class)
		);
	}

	/**
	 * @param int $customerId
	 * @param InvitationsSearchableProcessor $processor
	 * @return Response
	 */
	public function index($customerId, InvitationsSearchableProcessor $processor)
	{
		$adapter = new DefaultPaginatorAdapter([
			'getAll' => function($page, $perPage) use ($customerId, $processor){
				$options = new FetchInvitationsOptions();
				$options->setPagination(new PaginationOptions($page, $perPage));
				$options->setSortables($processor->createSortables());
				return $this->invitationService->getAllByCustomerId($customerId, $options);
			},
			'getTotal' => function() use ($customerId, $processor){
				return $this->invitationService->getTotalByCustomerId($customerId);
			}
		]);

		return $this->resource->makeAll(
			$this->paginator($adapter),
			$this->transformer(InvitationTransformer::class)
		);
	}

	/**
	 * @param int $customerId
	 * @param int $invitationId
	 * @return Response
	 */
	public function show($customerId, $invitationId)
	{
		return $this->resource->make(
			$this->invitationService->get($invitationId),
			$this->transformer(InvitationTransformer::class)
		);
	}

	/**
	 * @param CustomerService $customerService
	 * @param int $customerId
	 * @param int $invitationId
	 * @return bool
	 */
	public static function verifyAction(CustomerService $customerService, $customerId, $invitationId = null)
	{
		if (!$customerService->exists($customerId)){
			return false;
		}

		if ($invitationId === null){
			return true;
		}

		return $customerService->hasInvitation($customerId, $invitationId);
	}
}