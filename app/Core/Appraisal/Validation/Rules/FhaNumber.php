<?php
namespace RealEstate\Core\Appraisal\Validation\Rules;
use Restate\Libraries\Validation\Error;
use Restate\Libraries\Validation\Rules\AbstractRule;
use Restate\Libraries\Validation\Rules\Regex;
use Restate\Libraries\Validation\Value;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class FhaNumber extends AbstractRule
{
    public function __construct()
    {
        $this->setIdentifier('format')
            ->setMessage('The FHA number must contain only letters, digits, and dashes.');
    }

    /**
     * @param mixed|Value $value
     * @return Error|null
     */
    public function check($value)
    {
        $error = (new Regex('/^[a-zA-Z0-9\-]+$/'))->check($value);

        if ($error) {
            return $this->getError();
        }

        return null;
    }
}