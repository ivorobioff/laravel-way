<?php
namespace RealEstate\Core\Shared\Validation\Rules;
use Restate\Libraries\Validation\Error;
use Restate\Libraries\Validation\Rules\AbstractRule;
use Restate\Libraries\Validation\Rules\NullProcessableRuleInterface;
use Restate\Libraries\Validation\Value;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class NotNullable extends AbstractRule implements NullProcessableRuleInterface
{
    public function __construct()
    {
        $this->setIdentifier('not-nullable');
        $this->setMessage('The "null" value is not allowed for this field.');
    }

    /**
     * @param mixed|Value $value
     * @return Error|null
     */
    public function check($value)
    {
        if ($value === null){
            return $this->getError();
        }

        return null;
    }
}