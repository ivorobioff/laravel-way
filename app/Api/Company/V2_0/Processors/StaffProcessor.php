<?php
namespace RealEstate\Api\Company\V2_0\Processors;
use RealEstate\Api\Support\BaseProcessor;
use RealEstate\Core\Company\Persistables\StaffPersistable;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class StaffProcessor extends BaseProcessor
{
    /**
     * @return array
     */
    public function configuration()
    {
        return self::getPayloadSpecification();
    }

    /**
     * @return array
     */
    public static function getPayloadSpecification()
    {
        return [
            'isAdmin' => 'bool',
            'isManager' => 'bool',
            'isRfpManager' => 'bool',
            'branch' => 'int',
            'email' => 'string',
            'phone' => 'string'
        ];
    }

    /**
     * @return StaffPersistable
     */
    public function createPersistable()
    {
        return $this->populate(new StaffPersistable());
    }
}