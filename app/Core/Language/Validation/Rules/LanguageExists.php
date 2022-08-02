<?php
namespace RealEstate\Core\Language\Validation\Rules;

use Restate\Libraries\Validation\Error;
use Restate\Libraries\Validation\Rules\AbstractRule;
use Restate\Libraries\Validation\Value;
use RealEstate\Core\Language\Services\LanguageService;

/**
 *
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class LanguageExists extends AbstractRule
{

    /**
     *
     * @var LanguageService
     */
    private $languageService;

    public function __construct(LanguageService $languageService)
    {
        $this->languageService = $languageService;

        $this->setIdentifier('exists');
        $this->setMessage('The language with the specified code does not exist.');
    }

    /**
     *
     * @param mixed|Value $value
     * @return Error|null
     */
    public function check($value)
    {
        if (! $this->languageService->exists($value)) {
            return $this->getError();
        }

        return null;
    }
}