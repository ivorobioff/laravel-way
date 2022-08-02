<?php
namespace RealEstate\Core\Customer\Services;
use Restate\Libraries\Validation\PresentableException;
use RealEstate\Core\Appraisal\Entities\Order;
use RealEstate\Core\Customer\Entities\Customer;
use RealEstate\Core\Customer\Entities\Rules;
use RealEstate\Core\Customer\Entities\Ruleset;
use RealEstate\Core\Customer\Persistables\RulesetPersistable;
use RealEstate\Core\Customer\Validation\RulesetValidator;
use RealEstate\Core\Location\Entities\State;
use RealEstate\Core\Support\Service\AbstractService;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class RulesetService extends AbstractService
{
    /**
     * @param int $customerId
     * @param RulesetPersistable $persistable
     * @return Ruleset
     */
    public function create($customerId, RulesetPersistable $persistable)
    {
        (new RulesetValidator($this->container))->validate($persistable);

        $rules = new Rules();

        $this->entityManager->persist($rules);

        $this->entityManager->flush();

        $ruleset = new Ruleset();
        $ruleset->giveRules($rules);

        /**
         * @var Customer $customer
         */
        $customer = $this->entityManager->getReference(Customer::class, $customerId);

        $ruleset->setCustomer($customer);

        $this->exchange($persistable, $ruleset);

        $this->entityManager->persist($ruleset);

        $this->entityManager->flush();

        return $ruleset;
    }

    /**
     * @param $id
     * @param RulesetPersistable $persistable
     */
    public function update($id, RulesetPersistable $persistable)
    {
        (new RulesetValidator($this->container))->validate($persistable, true);

        /**
         * @var Ruleset $ruleset
         */
        $ruleset = $this->entityManager->find(Ruleset::class, $id);

        $this->exchange($persistable, $ruleset);

        $this->entityManager->flush();
    }

    /**
     * @param RulesetPersistable $persistable
     * @param Ruleset $ruleset
     */
    private function exchange(RulesetPersistable $persistable, Ruleset $ruleset)
    {
        $this->transfer($persistable, $ruleset, [
            'ignore' => [
                'rules'
            ]
        ]);

        $rules = $ruleset->takeRules();

        $rules->reset();

        foreach ($persistable->getRules() as $name => $value){
            $rules->addAvailable($name);

            if (in_array($name, ['clientState', 'clientDisplayedOnReportState'])){

                if ($value !== null){
                    $value = $this->entityManager->find(State::class, $value);
                }
            }

            $rules->{'set'.$name}($value);
        }
    }

    /**
     * @param int $id
     * @return Ruleset
     */
    public function get($id)
    {
        return $this->entityManager->find(Ruleset::class, $id);
    }

    /**
     * @param int $id
     */
    public function delete($id)
    {
        if ($this->entityManager->getRepository(Order::class)->exists(['rulesets' => ['HAVE MEMBER', $id]])){
            throw new PresentableException('Unable to delete the provided ruleset since it is assigned to an order.');
        }

        /**
         * @var Ruleset $ruleset
         */
        $ruleset = $this->entityManager->getReference(Ruleset::class, $id);

        $this->entityManager->remove($ruleset);

        $this->entityManager->flush();
    }
}