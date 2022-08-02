<?php
namespace RealEstate\Core\Appraiser\Validation\Rules;

use Restate\Libraries\Validation\Error;
use Restate\Libraries\Validation\Rules\AbstractRule;
use Restate\Libraries\Validation\Value;
use RealEstate\Core\Appraiser\Services\AppraiserService;

/**
 *
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class LicenseNumberTaken extends AbstractRule
{

    /**
     *
     * @var AppraiserService
     */
    private $appraiserService;

    /**
     *
     * @param AppraiserService $appraiserService
     */
    public function __construct(AppraiserService $appraiserService)
    {
        $this->appraiserService = $appraiserService;
        $this->setIdentifier('already-taken');
        $this->setMessage('The provided license number is already taken by another appraiser.');
    }

    /**
     *
     * @param mixed|Value $value
     * @return Error|null
     */
    public function check($value)
    {
        list ($value, $state) = $value->extract();

        if ($this->appraiserService->existsWithLicenseNumberInState($value, $state)) {
            return $this->getError();
        }

        return null;
    }
}