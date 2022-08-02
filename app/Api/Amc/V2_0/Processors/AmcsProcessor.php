<?php
namespace RealEstate\Api\Amc\V2_0\Processors;
use Restate\Libraries\Validation\Rules\Enum;
use RealEstate\Api\Support\BaseProcessor;
use RealEstate\Core\Shared\Interfaces\EnvironmentInterface;
use RealEstate\Core\User\Enums\Status;
use RealEstate\Core\Amc\Persistables\AmcPersistable;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class AmcsProcessor extends BaseProcessor
{
    public function configuration()
    {
        $data = [
            'username' => 'string',
            'password' => 'string',
            'email' => 'string',
            'companyName' => 'string',
            'address1' => 'string',
            'address2' => 'string',
            'city' => 'string',
            'state' => 'string',
            'zip' => 'string',
            'phone' => 'string',
            'fax' => 'string',
            'lenders' => 'string'
        ];

        /**
         * @var EnvironmentInterface $environment
         */
        $environment = $this->container->make(EnvironmentInterface::class);

        if ($this->isAdmin() || $environment->isRelaxed()){
            $data['status'] = new Enum(Status::class);
        }

        return $data;
    }

    /**
     * @return AmcPersistable
     */
    public function createPersistable()
    {
        return $this->populate(new AmcPersistable());
    }
}