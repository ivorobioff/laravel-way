<?php
namespace RealEstate\Core\Location\Validation\Rules;

use Restate\Libraries\Validation\Error;
use Restate\Libraries\Validation\Rules\AbstractRule;
use Restate\Libraries\Validation\Value;
use RealEstate\Core\Location\Services\StateService;

/**
 *
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class StateExists extends AbstractRule
{
    /**
     * @var StateService
     */
    private $stateService;

    /**
     * @param StateService $stateService
     */
    public function __construct(StateService $stateService)
    {
        $this->stateService = $stateService;

        $this->setIdentifier('exists');
        $this->setMessage('The state does not exist.');
    }

    /**
     * @param mixed|Value $value
     * @return Error|null
     */
    public function check($value)
    {
        if (! $this->stateService->exists($value)) {
            return $this->getError();
        }

        return null;
    }
}