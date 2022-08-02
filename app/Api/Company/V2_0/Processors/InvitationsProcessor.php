<?php
namespace RealEstate\Api\Company\V2_0\Processors;

use Restate\Libraries\Validation\Rules\Enum;
use RealEstate\Api\Support\BaseProcessor;
use RealEstate\Core\Company\Persistables\InvitationPersistable;
use RealEstate\Core\Invitation\Enums\Requirement;

class InvitationsProcessor extends BaseProcessor
{
    /**
     * @return array
     */
    protected function configuration()
    {
        return [
            'ascAppraiser' => 'int',
            'email' => 'string',
            'phone' => 'string',
            'requirements' => [new Enum(Requirement::class)]
        ];
    }

    /**
     * @return InvitationPersistable
     */
    public function createPersistable()
    {
        return $this->populate(new InvitationPersistable());
    }
}
