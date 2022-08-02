<?php
namespace RealEstate\Api\Support\Validation\Rules;

use Restate\Libraries\Validation\Error;
use Restate\Libraries\Validation\Rules\AbstractRule;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 *
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class Document extends AbstractRule
{

    /**
     * File constructor.
     */
    public function __construct()
    {
        $this->setIdentifier('document');
        $this->setMessage('Document is not attached.');
    }

    /**
     *
     * @param mixed $value
     * @return Error|null
     */
    public function check($value)
    {
        if (! $value instanceof UploadedFile) {
            return $this->getError();
        }

        return null;
    }
}