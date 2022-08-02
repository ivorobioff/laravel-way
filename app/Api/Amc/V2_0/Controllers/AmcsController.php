<?php
namespace RealEstate\Api\Amc\V2_0\Controllers;
use Illuminate\Http\Response;
use RealEstate\Api\Amc\V2_0\Processors\AmcsProcessor;
use RealEstate\Api\Amc\V2_0\Transformers\AmcTransformer;
use RealEstate\Api\Support\BaseController;
use RealEstate\Api\Support\DefaultPaginatorAdapter;
use RealEstate\Core\Amc\Options\FetchAmcsOptions;
use RealEstate\Core\Amc\Services\AmcService;
use RealEstate\Core\Shared\Options\PaginationOptions;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class AmcsController extends BaseController
{
    /**
     * @var AmcService
     */
    private $amcService;

    /**
     * @param AmcService $amcService
     */
    public function initialize(AmcService $amcService)
    {
        $this->amcService = $amcService;
    }

    /**
     * @return Response
     */
    public function index()
    {
        $adapter = new DefaultPaginatorAdapter([
            'getAll' => function($page, $perPage){
                $options = new FetchAmcsOptions();
                $options->setPagination(new PaginationOptions($page, $perPage));
                return $this->amcService->getAll($options);
            },
            'getTotal' => function(){
                return $this->amcService->getTotal();
            }
        ]);

        return $this->resource->makeAll(
            $this->paginator($adapter),
            $this->transformer(AmcTransformer::class)
        );
    }

    /**
     * @param AmcsProcessor $processor
     * @return Response
     */
    public function store(AmcsProcessor $processor)
    {
        return $this->resource->make(
            $this->amcService->create($processor->createPersistable()),
            $this->transformer(AmcTransformer::class)
        );
    }

    /**
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return $this->resource->make($this->amcService->get($id), $this->transformer(AmcTransformer::class));
    }

    /**
     * @param int $id
     * @param AmcsProcessor $processor
     * @return Response
     */
    public function update($id, AmcsProcessor $processor)
    {
        $this->amcService->update($id, $processor->createPersistable(), $processor->schedulePropertiesToClear());

        return $this->resource->blank();
    }

    /**
     * @param AmcService $amcService
     * @param int $id
     * @return bool
     */
    public static function verifyAction(AmcService $amcService, $id)
    {
        return $amcService->exists($id);
    }
}