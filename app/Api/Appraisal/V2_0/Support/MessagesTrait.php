<?php
namespace RealEstate\Api\Appraisal\V2_0\Support;
use Restate\Libraries\Validation\Error;
use Restate\Libraries\Validation\ErrorsThrowableCollection;
use RealEstate\Core\Appraisal\Exceptions\ReaderNotRelatedException;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
trait MessagesTrait
{
    /**
     * @param callable $callback
     * @throws ErrorsThrowableCollection
     */
    protected function tryMarkAsRead(callable  $callback)
    {
        try {
            $callback();
        } catch (ReaderNotRelatedException $ex){
            $errors = new ErrorsThrowableCollection();

            $errors['messages'] = new Error('permissions', $errors->getMessage());

            throw $errors;
        }
    }
}