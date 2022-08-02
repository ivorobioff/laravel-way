<?php
namespace RealEstate\Core\Amc\Validation\Rules;
use Restate\Libraries\Validation\Error;
use Restate\Libraries\Validation\Rules\AbstractRule;
use Restate\Libraries\Validation\Value;
use RealEstate\Core\Amc\Entities\License;
use RealEstate\Core\Amc\Services\LicenseService;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class LicenseNumberAvailable extends AbstractRule
{
    /**
     * @var LicenseService
     */
    private $licenseService;

    /**
     * @var License
     */
    private $ignoreLicense;

    public function __construct(LicenseService $licenseService, License $license = null)
    {
        $this->licenseService = $licenseService;
        $this->ignoreLicense = $license;

        $this->setIdentifier('already-taken');
        $this->setMessage('The license number is taken by another AMC');
    }

    /**
     * @param mixed|Value $value
     * @return Error|null
     */
    public function check($value)
    {
        list($number, $state) = $value->extract();

        if ($this->ignoreLicense
            && $this->ignoreLicense->getNumber() === $number
            && $this->ignoreLicense->getState()->getCode() === $state
        ){
            return null;
        }

        if ($this->licenseService->existsWithNumberInState($number, $state)){
            return $this->getError();
        }

        return null;
    }
}