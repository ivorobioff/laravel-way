<?php
namespace RealEstate\Core\Location\Validation\Rules;

use Restate\Libraries\Validation\Error;
use Restate\Libraries\Validation\Rules\AbstractRule;
use Restate\Libraries\Validation\Rules\Regex;
use Restate\Libraries\Validation\Value;

/**
 *
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class Zip extends AbstractRule
{
    public function __construct()
    {
        $this->setIdentifier('format');
        $this->setMessage('The zip code must be 5 digits long.');
    }

    /**
     * @param mixed|Value $value
     * @return Error|null
     */
    public function check($value)
    {
        $error = (new Regex('/^([0-9]{5})|([0-9]{5}\-[0-9]{4})$/'))->check($value);

        if ($error) {
            return $this->getError();
        }

        return null;
    }
}