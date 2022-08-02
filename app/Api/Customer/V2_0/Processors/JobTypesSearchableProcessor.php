<?php
namespace RealEstate\Api\Customer\V2_0\Processors;
use RealEstate\Api\Support\Searchable\BaseSearchableProcessor;
use RealEstate\Core\Support\Criteria\Constraint;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class JobTypesSearchableProcessor extends BaseSearchableProcessor
{
    /**
     * @return array
     */
    protected function configuration()
    {
        return [
            'filter' => [
                'isPayable' => [
                    'constraint' => Constraint::EQUAL,
                    'type' => 'bool'
                ]
            ]
        ];
    }
}