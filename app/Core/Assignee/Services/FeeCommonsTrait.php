<?php
namespace RealEstate\Core\Assignee\Services;

use Restate\Libraries\Validation\PresentableException;
use RealEstate\Core\Assignee\Persistables\FeePersistable;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
trait FeeCommonsTrait
{
    /**
     * @param array $hash
     * @param FeePersistable[] $persistables
     */
    protected function verifyJobTypesUniqueness(array $hash, array $persistables)
    {
        if (count($hash) !== count($persistables)){
            throw new PresentableException('The job types must be unique in the current collection.');
        }
    }

    /**
     * @param array $hash
     */
    protected function verifyFeeAmounts(array $hash)
    {
        if (min(array_values($hash)) < 0){
            throw new PresentableException('The fees must be greater than 0.');
        }
    }

    /**
     * @param FeePersistable[] $persistables
     * @return array
     */
    protected function prepareJobTypeAmountHash(array $persistables)
    {
        $hash = [];

        foreach ($persistables as $persistable){
            $hash[$persistable->getJobType()] = $persistable->getAmount();
        }

        return $hash;
    }
}