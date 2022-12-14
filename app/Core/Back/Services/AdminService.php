<?php
namespace RealEstate\Core\Back\Services;
use RealEstate\Core\Back\Entities\Admin;
use RealEstate\Core\Back\Persistables\AdminPersistable;
use RealEstate\Core\Back\Validation\AdminValidator;
use RealEstate\Core\Shared\Options\UpdateOptions;
use RealEstate\Core\Support\Service\AbstractService;
use RealEstate\Core\User\Interfaces\PasswordEncryptorInterface;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class AdminService extends AbstractService
{
    /**
     * @param AdminPersistable $persistable
     * @return Admin
     */
    public function create(AdminPersistable $persistable)
    {
        (new AdminValidator($this->container))->validate($persistable);

        $admin = new Admin();

        $this->exchange($persistable, $admin);

        $this->entityManager->persist($admin);

        $this->entityManager->flush();

        return $admin;
    }

    /**
     * @param int $id
     * @param AdminPersistable $persistable
     * @param UpdateOptions $options
     */
    public function update($id, AdminPersistable $persistable, UpdateOptions $options = null)
    {
        if ($options === null){
            $options = new UpdateOptions();
        }

        /**
         * @var Admin $admin
         */
        $admin = $this->entityManager->find(Admin::class, $id);

        (new AdminValidator($this->container))
            ->setCurrentAdmin($admin)
            ->setForcedProperties($options->getPropertiesScheduledToClear())
            ->validate($persistable, true);

        $this->exchange($persistable, $admin, $options->getPropertiesScheduledToClear());

        $this->entityManager->flush();
    }

    /**
     * @param AdminPersistable $persistable
     * @param Admin $admin
     * @param array $nullable
     */
    private function exchange(AdminPersistable $persistable, Admin $admin, array $nullable = [])
    {
        $this->transfer($persistable, $admin, [
            'ignore' => [
                'password'
            ],
            'nullable' => $nullable
        ]);

        if ($password = $persistable->getPassword()){
            /**
             * @var PasswordEncryptorInterface $encryptor
             */
            $encryptor = $this->container->get(PasswordEncryptorInterface::class);

            $admin->setPassword($encryptor->encrypt($password));
        }
    }

    /**
     * @param int $id
     * @return Admin
     */
    public function get($id)
    {
        return $this->entityManager->find(Admin::class, $id);
    }

    /**
     * @param int $id
     */
    public function exists($id)
    {
        return $this->entityManager->getRepository(Admin::class)->exists(['id' => $id]);
    }
}