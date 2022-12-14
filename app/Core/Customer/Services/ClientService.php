<?php
namespace RealEstate\Core\Customer\Services;
use RealEstate\Core\Customer\Entities\Client;
use RealEstate\Core\Customer\Entities\Customer;
use RealEstate\Core\Customer\Options\FetchClientsOptions;
use RealEstate\Core\Customer\Persistables\ClientPersistable;
use RealEstate\Core\Customer\Validation\ClientValidator;
use RealEstate\Core\Location\Entities\State;
use RealEstate\Core\Location\Services\StateService;
use RealEstate\Core\Shared\Options\UpdateOptions;
use RealEstate\Core\Support\Criteria\Paginator;
use RealEstate\Core\Support\Service\AbstractService;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class ClientService extends AbstractService
{
    /**
     * @param int $customerId
     * @param ClientPersistable $persistable
     * @return Client
     */
    public function create($customerId, ClientPersistable $persistable)
    {
        /**
         * @var StateService $stateService
         */
        $stateService = $this->container->get(StateService::class);

        (new ClientValidator($stateService))->validate($persistable);

        /**
         * @var Customer $customer
         */
        $customer = $this->entityManager->getReference(Customer::class, $customerId);

        $client = new Client();
        $client->setCustomer($customer);

        $this->exchange($persistable, $client);

        $this->entityManager->persist($client);
        $this->entityManager->flush();

        return $client;
    }

    /**
     * @param int $id
     * @param ClientPersistable $persistable
     * @param UpdateOptions $options
     * @return Client
     */
    public function update($id, ClientPersistable $persistable, UpdateOptions $options = null)
    {
        if ($options === null){
            $options = new UpdateOptions();
        }

        /**
         * @var StateService $stateService
         */
        $stateService = $this->container->get(StateService::class);

        (new ClientValidator($stateService))->validate($persistable, true);

        /**
         * @var Client $client
         */
        $client = $this->entityManager->find(Client::class, $id);

        $this->exchange($persistable, $client, $options->getPropertiesScheduledToClear());

        $this->entityManager->flush();
    }

    /**
     * @param ClientPersistable $persistable
     * @param Client $client
     * @param array $nullable
     */
    private function exchange(ClientPersistable $persistable, Client $client, array $nullable = [])
    {
        $this->transfer($persistable, $client, [
            'ignore' => [
                'state'
            ],
            'nullable' => $nullable
        ]);

        if ($persistable->getState()){
            /**
             * @var State $state
             */
            $state = $this->entityManager->getReference(State::class, $persistable->getState());

            $client->setState($state);
        } else if (in_array('state', $nullable)){
            $client->setState(null);
        }
    }

    /**
     * @param int $id
     * @return Client
     */
    public function get($id)
    {
        return $this->entityManager->find(Client::class, $id);
    }

    /**
     * @param int $customerId
     * @param FetchClientsOptions $options
     * @return Client[]
     */
    public function getAll($customerId, FetchClientsOptions $options = null)
    {
        $builder = $this->entityManager->createQueryBuilder();

        $builder->from(Client::class, 'c')
            ->select('c')
            ->where($builder->expr()->eq('c.customer', ':customer'))
            ->setParameter('customer', $customerId);

        return (new Paginator())->apply($builder, $options->getPagination());
    }

    /**
     * @param int $customerId
     * @return int
     */
    public function getTotal($customerId)
    {
        $builder = $this->entityManager->createQueryBuilder();

        $builder->from(Client::class, 'c')
            ->select($builder->expr()->countDistinct('c'))
            ->where($builder->expr()->eq('c.customer', ':customer'))
            ->setParameter('customer', $customerId);

        return (int) $builder->getQuery()->getSingleScalarResult();
    }
}