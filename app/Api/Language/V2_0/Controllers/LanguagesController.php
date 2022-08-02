<?php
namespace RealEstate\Api\Language\V2_0\Controllers;

use Illuminate\Http\Response;
use RealEstate\Api\Language\V2_0\Transformers\LanguageTransformer;
use RealEstate\Api\Support\BaseController;
use RealEstate\Core\Language\Services\LanguageService;

/**
 *
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class LanguagesController extends BaseController
{

    /**
     *
     * @var LanguageService
     */
    private $languageService;

    /**
     *
     * @param LanguageService $languageService
     */
    public function initialize(LanguageService $languageService)
    {
        $this->languageService = $languageService;
    }

    /**
     *
     * @return Response
     */
    public function index()
    {
        return $this->resource->makeAll($this->languageService->getAll(), $this->transformer(LanguageTransformer::class));
    }
}