<?php
namespace RealEstate\Api\Company\V2_0\Processors;
use RealEstate\Api\Support\Searchable\BaseSearchableProcessor;
use RealEstate\Core\Appraiser\Entities\Appraiser;
use RealEstate\Core\Company\Entities\Manager;
use RealEstate\Core\Support\Criteria\Constraint;
use RealEstate\Core\Support\Criteria\Criteria;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class StaffSearchableProcessor extends BaseSearchableProcessor
{
    protected function configuration()
    {
        return [
            'filter' => [
                'user.type' => function($value){
                    if (!in_array($value, ['appraiser', 'manager'], true)){
                        return null;
                    }

                    $constraint = new Constraint(Constraint::EQUAL);

                    $class = $value === 'manager' ? Manager::class : Appraiser::class;

                    return new Criteria('user.class', $constraint, $class);
                },
            ]
        ];
    }
}