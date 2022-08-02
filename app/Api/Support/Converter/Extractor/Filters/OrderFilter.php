<?php
namespace RealEstate\Api\Support\Converter\Extractor\Filters;
use Restate\Libraries\Converter\Extractor\Root;
use RealEstate\Core\Appraisal\Entities\Order;
use RealEstate\Core\Customer\Entities\Customer;
use RealEstate\Core\Customer\Enums\Rule;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class OrderFilter extends AbstractFilter
{
    /**
     * @param string $key
     * @param Order $object
     * @param Root $root
     * @return bool
     */
    public function isAllowed($key, $object, Root $root = null)
    {
        $actsAsAssignee = $this->environment->getAssigneeAsWhoActorActs() !== null;

        if (($this->session->getUser() instanceof Customer && !$actsAsAssignee)){
            return true;
        }

        if (in_array($key, [
            'clientName', 'clientAddress1', 'clientAddress2',
            'clientCity', 'clientState', 'clientZip', 'client'
        ])){
            $customer = $object->getCustomer();
            $settings = $customer->getSettings();

            return $settings->getShowClientToAppraiser() === true;
        }

        if ($key == 'fdic'){
            return $object->getRules()[Rule::DISPLAY_FDIC] ?? true;
        }

        return true;
    }
}