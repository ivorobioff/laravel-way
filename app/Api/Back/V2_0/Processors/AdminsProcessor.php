<?php
namespace RealEstate\Api\Back\V2_0\Processors;
use RealEstate\Api\Support\BaseProcessor;
use RealEstate\Core\Back\Persistables\AdminPersistable;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class AdminsProcessor extends BaseProcessor
{
    protected function configuration()
    {
        return [
            'username' => 'string',
            'password' => 'string',
            'firstName' => 'string',
            'lastName' => 'string',
            'email' => 'string'
        ];
    }

    /**
     * @return AdminPersistable
     */
    public function createPersistable()
    {
        return $this->populate(new AdminPersistable());
    }
}