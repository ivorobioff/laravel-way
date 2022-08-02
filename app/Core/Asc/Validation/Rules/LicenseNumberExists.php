<?php
namespace RealEstate\Core\Asc\Validation\Rules;

use Restate\Libraries\Validation\Error;
use Restate\Libraries\Validation\Rules\AbstractRule;
use Restate\Libraries\Validation\Value;
use RealEstate\Core\Asc\Services\AscService;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class LicenseNumberExists extends AbstractRule
{
    /**
     * @var AscService
     */
    private $ascService;

    public function __construct(AscService $ascService)
    {
        $this->setIdentifier('exists');
        $this->setMessage('The specified license number belongs to none of appraisers in the asc database.');

        $this->ascService = $ascService;
    }

    /**
     * @param mixed|Value $value
     * @return Error|null
     */
    public function check($value)
    {
        list ($licenseNumber, $state) = $value->extract();

        if (! $this->ascService->existsWithLicenseNumberInState($licenseNumber, $state)) {
            return $this->getError();
        }

        return null;
    }
}