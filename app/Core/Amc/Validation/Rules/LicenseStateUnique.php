<?php
namespace RealEstate\Core\Amc\Validation\Rules;
use Restate\Libraries\Validation\Error;
use Restate\Libraries\Validation\Rules\AbstractRule;
use RealEstate\Core\Amc\Entities\Amc;
use RealEstate\Core\Amc\Entities\License;
use RealEstate\Core\Amc\Services\AmcService;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class LicenseStateUnique extends AbstractRule
{
    /**
     * @var AmcService
     */
    private $amcService;

    /**
     * @var Amc
     */
    private $currentAmc;

    /**
     * @var License
     */
    private $ignoreLicense;

    /**
     * @param AmcService $amcService
     * @param Amc $amc
     * @param License $ignoreLicense
     */
    public function __construct(AmcService $amcService, Amc $amc, License $ignoreLicense = null)
    {
        $this->amcService = $amcService;
        $this->currentAmc = $amc;
        $this->ignoreLicense = $ignoreLicense;

        $this->setIdentifier('unique');
        $this->setMessage('The license has been added already for the specified state.');
    }

    /**
     * @param mixed|Value $value
     * @return Error|null
     */
    public function check($value)
    {
        if ($this->ignoreLicense && $this->ignoreLicense->getState()->getCode() === $value){
            return null;
        }

        if ($this->amcService->hasLicenseInState($this->currentAmc->getId(), $value)){
            return $this->getError();
        }

        return null;
    }
}