<?php
namespace RealEstate\Api\Document\V2_0\Controllers;

use Restate\Libraries\Validation\Error;
use Restate\Libraries\Validation\ErrorsThrowableCollection;
use Illuminate\Http\Response;
use RealEstate\Api\Document\V2_0\Processors\DocumentsProcessor;
use RealEstate\Api\Document\V2_0\Processors\ExternalDocumentsProcessor;
use RealEstate\Api\Document\V2_0\Transformers\DocumentTransformer;
use RealEstate\Api\Support\BaseController;
use RealEstate\Core\Document\Exceptions\InvalidFormatException;
use RealEstate\Core\Document\Services\DocumentService;

/**
 *
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class DocumentsController extends BaseController
{

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
     * @param DocumentsProcessor $processor
     * @return Response
	 * @throws ErrorsThrowableCollection
     */
    public function store(DocumentsProcessor $processor)
    {
		try {
			$document = $this->documentService->create($processor->createPersistable());
		} catch (ErrorsThrowableCollection $ex){
			$ex['document'] = $ex['location'];
			unset($ex['location']);
			throw $ex;
		} catch (InvalidFormatException $ex){
			$errors = new ErrorsThrowableCollection();
			$errors['document'] = new Error('format', $ex->getMessage());
			throw $errors;
		}

        return $this->resource->make(
			$document,
			$this->transformer(DocumentTransformer::class)
		);
    }

	/**
	 * @param ExternalDocumentsProcessor $processor
	 * @return Response
	 */
	public function storeExternal(ExternalDocumentsProcessor $processor)
	{
		return $this->resource->make(
			$this->documentService->createExternal($processor->createPersistable()),
			$this->transformer(DocumentTransformer::class)
		);
	}
}