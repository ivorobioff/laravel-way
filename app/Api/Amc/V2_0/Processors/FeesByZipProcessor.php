<?php
namespace RealEstate\Api\Amc\V2_0\Processors;
use RealEstate\Api\Support\BaseProcessor;
use RealEstate\Api\Support\BulkHolder;
use RealEstate\Core\Amc\Persistables\FeeByZipPersistable;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class FeesByZipProcessor extends BaseProcessor
{
    /**
     * @return array
     */
    protected function configuration()
    {
        return [
            'data' => [
                'zip' => 'string',
                'amount' => 'float'
            ]
        ];
    }

    /**
     * @return FeeByZipPersistable[]
     */
    public function createPersistables()
    {
        $holder = new BulkHolder();

        $this->populate($holder, [
            'hint' => [
                'data' => 'collection:'.FeeByZipPersistable::class
            ]
        ]);

        return $holder->getData();
    }
}