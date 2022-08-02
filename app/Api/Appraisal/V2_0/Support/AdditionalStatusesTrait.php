<?php
namespace RealEstate\Api\Appraisal\V2_0\Support;
use Restate\Libraries\Validation\Error;
use Restate\Libraries\Validation\ErrorsThrowableCollection;
use RealEstate\Core\Appraisal\Exceptions\AdditionalStatusForbiddenException;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
trait AdditionalStatusesTrait
{
    /**
     * @param callable $callback
     */
    public function tryChangeAdditionalStatus(callable $callback)
    {
        try {
            $callback();
        } catch (AdditionalStatusForbiddenException $ex) {
            $errors = new ErrorsThrowableCollection();
            $errors['additionalStatus'] = new Error('permissions', $ex->getMessage());
            throw $errors;
        }
    }
}