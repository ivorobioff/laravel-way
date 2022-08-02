<?php
namespace RealEstate\Core\Company\Validation\Definers;
use Restate\Libraries\Validation\Binder;
use Restate\Libraries\Validation\Property;
use Restate\Libraries\Validation\Rules\Obligate;
use RealEstate\Core\Company\Entities\Manager;
use RealEstate\Core\Shared\Interfaces\EnvironmentInterface;
use RealEstate\Core\Shared\Validation\Rules\Phone;
use RealEstate\Core\Support\Service\ContainerInterface;
use RealEstate\Core\User\Services\UserService;
use RealEstate\Core\User\Validation\Inflators\EmailInflator;
use RealEstate\Core\User\Validation\Inflators\FirstNameInflator;
use RealEstate\Core\User\Validation\Inflators\LastNameInflator;
use RealEstate\Core\User\Validation\Inflators\PasswordInflator;
use RealEstate\Core\User\Validation\Inflators\UsernameInflator;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class ManagerDefiner
{
    /**
     * @var string
     */
    private $namespace;

    /**
     * @var UserService
     */
    private $userService;

    /**
     * @var Manager
     */
    private $currentManager;

    /**
     * @var EnvironmentInterface
     */
    private $environment;


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
     */
    public function define(Binder $binder)
    {
        if ($namespace = $this->namespace){
            $namespace .= '.';
        }

        $binder->bind($namespace.'username', new UsernameInflator($this->userService, $this->environment, $this->currentManager));
        $binder->bind($namespace.'password', new PasswordInflator($this->environment));

        $binder->bind($namespace.'firstName', new FirstNameInflator());
        $binder->bind($namespace.'lastName', new LastNameInflator());

        $binder->bind($namespace.'phone', function (Property $property) {
            $property
                ->addRule(new Obligate())
                ->addRule(new Phone());
        });

        $binder->bind($namespace.'email', new EmailInflator());
    }

    /**
     * @param Manager $manager
     * @return $this
     */
    public function setCurrentManager(Manager $manager)
    {
        $this->currentManager = $manager;
        return $this;
    }


    /**
     * @param string $namespace
     * @return $this
     */
    public function setNamespace($namespace)
    {
        $this->namespace = $namespace;
        return $this;
    }
}