<?php
namespace RealEstate\Api\Amc\V2_0\Processors;
use Restate\Libraries\Validation\Rules\Enum;
use RealEstate\Api\Support\BaseProcessor;
use RealEstate\Api\Support\BulkHolder;
use RealEstate\Core\Assignee\Persistables\FeePersistable;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class FeesProcessor extends BaseProcessor
{
    /**
     * @return array
     */
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