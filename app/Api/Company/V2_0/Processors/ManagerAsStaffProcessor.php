<?php
namespace RealEstate\Api\Company\V2_0\Processors;
use RealEstate\Api\Support\BaseProcessor;
use RealEstate\Core\Company\Persistables\ManagerAsStaffPersistable;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class ManagerAsStaffProcessor extends BaseProcessor
{
    /**
     * @return array
     */
    protected function configuration()
    {
        $data = StaffProcessor::getPayloadSpecification();

        $data['user'] = 'array';

        foreach (ManagersProcessor::getPayloadSpecification() as $field => $rule){
            $data['user.'.$field] = $rule;
        }

        $data['notifyUser'] = 'bool';

        return $data;
    }

    /**
     * @return bool
     */
    public function notifyUser()
    {
        return $this->get('notifyUser', false);
    }

    /**
     * @return ManagerAsStaffPersistable
     */
    public function createPersistable()
    {
        return $this->populate(new ManagerAsStaffPersistable());
    }
}