<?php
namespace RealEstate\Core\Customer\Validation\Rules;
use Restate\Libraries\Validation\Error;
use Restate\Libraries\Validation\Rules\AbstractRule;
use Restate\Libraries\Validation\Value;
use RealEstate\Core\Customer\Enums\Rule;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class AllowedRulesInRuleset extends AbstractRule
{
    public function __construct()
    {
        $this->setMessage('The provided rules must be in the list of the supported rules: '
            .implode(', ', Rule::toArray()));

        $this->setIdentifier('format');
    }

    /**
     * @param mixed|Value $value
     * @return Error|null
     */
    public function check($value)
    {
        $keys = array_keys($value);

        $supported = Rule::toArray();

        foreach ($keys as $key){
            if (!in_array($key, $supported, true)){
                return $this->getError();
            }
        }

        return null;
    }
}