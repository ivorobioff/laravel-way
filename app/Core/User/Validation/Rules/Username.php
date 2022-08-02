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
class Username extends AbstractRule
{
	const ALLOWED_CHARACTERS = '[a-zA-Z0-9\._@\-]+';

    public function __construct()
    {
        $this->setIdentifier('format');
        $this->setMessage('The username can contain only letters, digits, "@", ".", "-" or "_" '
			. 'must be at least 5 and at most 50 characters long.');
    }

    /**
     *
     * @param string $value
     * @return Error|null
     */
    public function check($value)
    {
        $error = (new Regex('/^'.static::ALLOWED_CHARACTERS.'$/'))->check($value);

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