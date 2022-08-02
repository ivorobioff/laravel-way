<?php
namespace RealEstate\Api\Amc\V2_0\Processors;
use RealEstate\Api\Support\BaseProcessor;
use RealEstate\Api\Support\BulkHolder;
use RealEstate\Core\Amc\Persistables\FeeByStatePersistable;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class FeesByStateBulkProcessor extends BaseProcessor
{
    /**
     * @return array
     */
    protected function configuration()
    {
        return [
            'data' => FeesByStateProcessor::metadata()
        ];
    }

    /**
     * @return FeeByStatePersistable[]
     */
    public function createPersistables()
    {
        $holder = new BulkHolder();

        $this->populate($holder, [
            'hint' => [
                'data' => 'collection:'.FeeByStatePersistable::class
            ]
        ]);

        return $holder->getData();
    }

    /**
     * @return array
     */
    public function getApplyStateAmountToAllCounties()
    {
        return array_column($this->get('data', []), 'applyStateAmountToAllCounties', 'state');
    }

    /**
     * @return array
     */
    public function getApplyStateAmountToAllZips()
    {
        return array_column($this->get('data', []), 'applyStateAmountToAllZips', 'state');
    }
}