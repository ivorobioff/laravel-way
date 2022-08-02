<?php
namespace RealEstate\Core\Back\Validation;
use Restate\Libraries\Validation\AbstractThrowableValidator;
use Restate\Libraries\Validation\Binder;
use RealEstate\Core\Back\Entities\Admin;
use RealEstate\Core\Shared\Interfaces\EnvironmentInterface;
use RealEstate\Core\Support\Service\ContainerInterface;
use RealEstate\Core\User\Services\UserService;
use RealEstate\Core\User\Validation\Inflators\EmailInflator;
use RealEstate\Core\User\Validation\Inflators\FirstNameInflator;
use RealEstate\Core\User\Validation\Inflators\LastNameInflator;
use RealEstate\Core\User\Validation\Inflators\PasswordInflator;
use RealEstate\Core\User\Validation\Inflators\UsernameInflator;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class AdminValidator extends AbstractThrowableValidator
{
    /**
     * @var UserService
     */
    private $userService;

    /**
     * @var EnvironmentInterface
     */
    private $environment;

    /**
     * @var Admin
     */
    private $currentAdmin;

    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->userService = $container->get(UserService::class);
        $this->environment = $container->get(EnvironmentInterface::class);
    }

    /**
     * @param Binder $binder
     * @return void
     */
    protected function define(Binder $binder)
    {
        $binder->bind('username', new UsernameInflator($this->userService, $this->environment, $this->currentAdmin));
        $binder->bind('password', new PasswordInflator($this->environment));
        $binder->bind('firstName', new FirstNameInflator());
        $binder->bind('lastName', new LastNameInflator());
        $binder->bind('email', new EmailInflator());
    }

    /**
     * @param Admin $admin
     * @return $this
     */
    public function setCurrentAdmin(Admin $admin)
    {
        $this->currentAdmin = $admin;

        return $this;
    }
}