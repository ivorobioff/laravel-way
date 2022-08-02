<?php
namespace RealEstate\Api\Appraisal\V2_0\Support;
use Restate\Libraries\Validation\Error;
use Restate\Libraries\Validation\ErrorsThrowableCollection;
use RealEstate\Core\Appraisal\Entities\Document;
use RealEstate\Core\Appraisal\Exceptions\ExtractFailedException;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */

trait DocumentsTrait
{
    /** @noinspection PhpInconsistentReturnPointsInspection */

    /**
     * @param callable $callback
     * @throws ErrorsThrowableCollection
     * @return Document
     *
     */
    protected function tryCreate(callable  $callback)
    {
        try {
            return $callback();
        } catch (ExtractFailedException $ex){
            ErrorsThrowableCollection::throwError('primary', new Error('invalid', $ex->getMessage()));
        }
    }
}