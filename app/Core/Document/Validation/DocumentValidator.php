<?php
namespace RealEstate\Core\Document\Validation;

use Restate\Libraries\Validation\AbstractThrowableValidator;
use Restate\Libraries\Validation\Binder;
use Restate\Libraries\Validation\Property;
use Restate\Libraries\Validation\Rules\Obligate;
use RealEstate\Core\Document\Support\Storage\StorageInterface;
use RealEstate\Core\Document\Validation\Rules\FileReadable;

/**
 *
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class DocumentValidator extends AbstractThrowableValidator
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
    }

    /**
     * @param Binder $binder
     * @return void
     */
    protected function define(Binder $binder)
    {
        $binder->bind('location', function (Property $property) {
            $property
				->addRule(new Obligate())
                ->addRule(new FileReadable($this->storage));
        });
    }
}