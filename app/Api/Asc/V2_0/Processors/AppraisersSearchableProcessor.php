<?php
namespace RealEstate\Api\Asc\V2_0\Processors;

use RealEstate\Api\Support\Searchable\BaseSearchableProcessor;
use RealEstate\Core\Support\Criteria\Constraint;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class AppraisersSearchableProcessor extends BaseSearchableProcessor
{
    protected function configuration()
    {
        return [
            'search' => [
                'licenseNumber' => Constraint::SIMILAR
            ],
            'filter' => [
                'licenseState' => Constraint::EQUAL,
				'isTied' => [
					'constraint' =>  Constraint::EQUAL,
					'type' => 'bool'
				]
            ]
        ];
    }
}