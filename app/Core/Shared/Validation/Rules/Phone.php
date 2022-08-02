<?php
namespace RealEstate\Core\Shared\Validation\Rules;

use Restate\Libraries\Validation\Error;
use Restate\Libraries\Validation\Rules\AbstractRule;
use Restate\Libraries\Validation\Rules\Regex;
use Restate\Libraries\Validation\Value;

/**
 *
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class Phone extends AbstractRule
{

    public function __construct()
    {
        $this->setIdentifier('format');
        $this->setMessage('The phone number must be provided in the following format: (xxx) xxx-xxxx');
    }

    /**
     *
     * @param mixed|Value $value
     * @return Error|null
     */
    public function check($value)
    {
        $error = (new Regex('/^\([0-9]{3}\) [0-9]{3}\-[0-9]{4}$/'))->check($value);

        if ($error) {
            return $this->getError();
        }

        return null;
    }
}