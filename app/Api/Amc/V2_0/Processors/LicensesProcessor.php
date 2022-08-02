<?php
namespace RealEstate\Api\Amc\V2_0\Processors;
use RealEstate\Api\Support\BaseProcessor;
use RealEstate\Core\Amc\Persistables\CoveragePersistable;
use RealEstate\Core\Amc\Persistables\LicensePersistable;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class LicensesProcessor extends BaseProcessor
{
    /**
     * @return array
     */
    protected function configuration()
    {
        return [
            'state' => 'string',
            'number' => 'string',
            'expiresAt' => 'datetime',
            'document' => 'document',
            'coverage' => [
                'county' => 'int',
                'zips' => 'string[]'
            ],
            'alias' => 'array',
            'alias.companyName' => 'string',
            'alias.address1' => 'string',
            'alias.address2' => 'string',
            'alias.city' => 'string',
            'alias.state' => 'string',
            'alias.zip' => 'string',
            'alias.phone' => 'string',
            'alias.fax' => 'string',
            'alias.email' => 'string',
        ];
    }

    /**
     * @return LicensePersistable
     */
    public function createPersistable()
    {
        return $this->populate(new LicensePersistable(), [
            'map' => [
                'coverage' => 'coverages'
            ],
            'hint' => [
                'coverage' => 'collection:'.CoveragePersistable::class
            ]
        ]);
    }
}