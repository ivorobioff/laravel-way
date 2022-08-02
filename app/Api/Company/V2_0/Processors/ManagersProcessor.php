<?php
namespace RealEstate\Api\Company\V2_0\Processors;

use RealEstate\Api\Support\BaseProcessor;
use RealEstate\Core\Company\Persistables\ManagerPersistable;

class ManagersProcessor extends BaseProcessor
{
    /**
     * @return array
     */
    protected function configuration()
    {
        return self::getPayloadSpecification();
    }


    public static function getPayloadSpecification()
    {
        return [
            'username' => 'string',
            'password' => 'string',
            'firstName' => 'string',
            'lastName' => 'string',
            'phone' => 'string',
            'email' => 'string'
        ];
    }

    /**
     * @return ManagerPersistable
     */
    public function createPersistable()
    {
        return $this->populate(new ManagerPersistable());
    }
}
