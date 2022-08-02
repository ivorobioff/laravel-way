<?php
namespace RealEstate\Core\Company\Services;

use RealEstate\Core\Appraisal\Services\OrderService;
use RealEstate\Core\Company\Entities\Manager;
use RealEstate\Core\Company\Options\CreateManagerOptions;
use RealEstate\Core\Company\Persistables\ManagerPersistable;
use RealEstate\Core\Company\Validation\ManagerValidator;
use RealEstate\Core\Shared\Options\UpdateOptions;
use RealEstate\Core\Support\Service\AbstractService;
use RealEstate\Core\User\Interfaces\PasswordEncryptorInterface;

class ManagerService extends AbstractService
{
    /**
     * @param int $id
     * @return Manager
     */
    public function get($id)
    {
        return $this->entityManager->find(Manager::class, $id);
    }

    /**
     * @param ManagerPersistable $persistable
     * @param CreateManagerOptions $options
     * @return Manager
     */
    public function create(ManagerPersistable $persistable, CreateManagerOptions $options = null)
    {
        if ($options === null){
            $options = new CreateManagerOptions();
        }

        if (!$options->isTrusted()){
            (new ManagerValidator($this->container))->validate($persistable);
        }

        $manager = new Manager();

        $this->exchange($persistable, $manager);

        $this->entityManager->persist($manager);

        $this->entityManager->flush();

        return $manager;
    }

    /**
     * @param int $id
     * @param ManagerPersistable $persistable
     * @param UpdateOptions $options
     */
    public function update($id, ManagerPersistable $persistable, UpdateOptions $options = null)
    {
        if ($options === null){
            $options = new UpdateOptions();
        }

        $nullable = $options->getPropertiesScheduledToClear();

        /**
         * @var Manager $manager
         */
        $manager = $this->entityManager->find(Manager::class, $id);

        (new ManagerValidator($this->container))
            ->setCurrentManager($manager)
            ->setForcedProperties($nullable)
            ->validate($persistable, true);

        $this->exchange($persistable, $manager, $nullable);

        $this->entityManager->flush();
    }

    /**
     * @param ManagerPersistable $persistable
     * @param Manager $manager
     * @param array $nullable
     */
    private function exchange(ManagerPersistable $persistable, Manager $manager, array $nullable = [])
    {
        $this->transfer($persistable, $manager, [
            'nullable' => $nullable,
            'ignore' => ['password']
        ]);

        if ($password = $persistable->getPassword()){
            /**
             * @var PasswordEncryptorInterface $encrypter
             */
            $encrypter = $this->container->get(PasswordEncryptorInterface::class);
            $manager->setPassword($encrypter->encrypt($password));
        }
    }

    /**
     * @param int $id
     */
    public function delete($id)
    {
        $manager = $this->entityManager->getReference(Manager::class, $id);
        $this->entityManager->remove($manager);
        $this->entityManager->flush();
    }

    /**
     * @param int $id
     * @return bool
     */
    public function exists($id)
    {
        return $this->entityManager->getRepository(Manager::class)->exists(['id' => $id]);
    }

    /**
     * @param int $managerId
     * @param int $orderId
     * @return bool
     */
    public function hasOrder($managerId, $orderId)
    {
        /**
         * @var OrderService $orderService
         */
        $orderService = $this->container->get(OrderService::class);

        return $orderService->existsByAssigneeId($orderId, $managerId, true);
    }
}
