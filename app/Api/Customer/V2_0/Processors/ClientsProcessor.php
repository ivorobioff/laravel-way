<?php
namespace RealEstate\Api\Customer\V2_0\Processors;
use RealEstate\Api\Support\BaseProcessor;
use RealEstate\Core\Customer\Persistables\ClientPersistable;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class ClientsProcessor extends BaseProcessor
{
    protected function configuration()
    {
        return [
            'name' => 'string',
            'address1' => 'string',
            'address2' => 'string',
            'zip' => 'string',
            'city' => 'string',
            'state' => 'string'
        ];
    }

    /**
     * @return ClientPersistable
     */
    public function createPersistable()
    {
        return $this->populate(new ClientPersistable());
    }
}