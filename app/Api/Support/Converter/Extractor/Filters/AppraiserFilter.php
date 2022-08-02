<?php
namespace RealEstate\Api\Support\Converter\Extractor\Filters;
use Restate\Libraries\Converter\Extractor\Root;
use RealEstate\Core\Appraiser\Entities\Appraiser;
use RealEstate\Core\Customer\Entities\Customer;
use RealEstate\Core\Customer\Services\CustomerService;
use RealEstate\Support\Shortcut;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class AppraiserFilter extends AbstractFilter
{
    /**
     * @param string $key
     * @param Appraiser $object
     * @param Root|null $root
     * @return bool
     */
    public function isAllowed($key, $object, Root $root = null)
    {
        if (in_array($this->getRoute(), [
                Shortcut::prependGlobalRoutePrefix('v2.0/sessions'),
                Shortcut::prependGlobalRoutePrefix('v2.0/appraisers')
            ]) && $this->isPost()){
            return true;
        }

        if ($object->getId() === object_take($this->session, 'user.id')){
            return true;
        }

        $user = $this->session->getUser();

        if ($user instanceof Customer){
            /**
             * @var CustomerService $customerService
             */
            $customerService = $this->container->make(CustomerService::class);

            if ($customerService->isRelatedWithAppraiser($user->getId(), $object->getId())){
                return true;
            }
        }

        if (in_array($key, ['w9', 'taxIdentificationNumber'])){
            return false;
        }

        return true;
    }
}