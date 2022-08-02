<?php
namespace RealEstate\Core\User\Validation\Rules;

use Restate\Libraries\Validation\Error;
use Restate\Libraries\Validation\Rules\AbstractRule;
use Restate\Libraries\Validation\Rules\Length;
use Restate\Libraries\Validation\Rules\Regex;

/**
 *
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class Password extends AbstractRule
{
	const ALLOWED_CHARACTERS = '`~!@#$%^&*()_+=-?/\|.,\'"<>{}[]:;';


    public function __construct()
    {
        $this->setIdentifier('format');

        $this->setMessage('The password must be at least 5 and at most 255 characters long. The password can contain the following characters '.static::ALLOWED_CHARACTERS.' as well as english letters, digits and spaces.');
    }

    /**
     *
     * @param string $value
     * @return Error|null
     */
    public function check($value)
    {
        $error = (new Regex('/^[a-zA-Z0-9 '.preg_quote(static::ALLOWED_CHARACTERS, '/').']+$/'))->check($value);

        if ($error) {
            return $this->getError();
        }

        $error = (new Length(5, 255))->check($value);

        if ($error) {
            return $this->getError();
        }

        return null;
    }
}