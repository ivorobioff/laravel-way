<?php
namespace RealEstate\Core\Document\Validation\Rules;

use Restate\Libraries\Validation\Error;
use Restate\Libraries\Validation\Rules\AbstractRule;
use RealEstate\Core\Document\Support\Storage\StorageInterface;

/**
 *
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class FileReadable extends AbstractRule
{

    /**
     * @var StorageInterface
     */
    private $storage;

    /**
     * @param StorageInterface $storage
     */
    public function __construct(StorageInterface $storage)
    {
        $this->storage = $storage;

        $this->setIdentifier('file-access');
        $this->setMessage('Cannot access the uploaded file.');
    }

    /**
     * @param mixed $location
     * @return Error|null
     */
    public function check($location)
    {
        if (! $this->storage->isFileReadable($location)) {
            return $this->getError();
        }

        return null;
    }
}