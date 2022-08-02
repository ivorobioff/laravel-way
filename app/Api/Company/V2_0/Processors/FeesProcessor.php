<?php
namespace RealEstate\Api\Company\V2_0\Processors;
use RealEstate\Api\Support\BaseProcessor;
use RealEstate\Api\Support\BulkHolder;
use RealEstate\Core\Company\Persistables\FeePersistable;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class FeesProcessor extends BaseProcessor
{
    protected function configuration()
    {
        return [
            'data' => [
                'jobType' => 'int',
                'amount' => 'float'
            ]
        ];
    }

    /**
     * @return FeePersistable[]
     */
    public function createPersistables()
    {
        $holder = new BulkHolder();

        $this->populate($holder, [
            'hint' => [
                'data' => 'collection:'.FeePersistable::class
            ]
        ]);

        return $holder->getData();
    }
}