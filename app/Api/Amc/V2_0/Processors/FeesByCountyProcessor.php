<?php
namespace RealEstate\Api\Amc\V2_0\Processors;
use RealEstate\Api\Support\BaseProcessor;
use RealEstate\Api\Support\BulkHolder;
use RealEstate\Core\Amc\Persistables\FeeByCountyPersistable;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class FeesByCountyProcessor extends BaseProcessor
{
    /**
     * @return array
     */
    protected function configuration()
    {
        return [
            'data' => [
                'county' => 'int',
                'amount' => 'float',
            ]
        ];
    }

    /**
     * @return FeeByCountyPersistable[]
     */
    public function createPersistables()
    {
        $holder = new BulkHolder();

        $this->populate($holder, [
            'hint' => [
                'data' => 'collection:'.FeeByCountyPersistable::class
            ]
        ]);

        return $holder->getData();
    }
}