<?php
namespace RealEstate\Core\Amc\Validation;
use Restate\Libraries\Validation\AbstractThrowableValidator;
use Restate\Libraries\Validation\Binder;
use Restate\Libraries\Validation\Property;
use Restate\Libraries\Validation\Rules\Blank;
use Restate\Libraries\Validation\Rules\Length;
use Restate\Libraries\Validation\Rules\Obligate;
use RealEstate\Core\Amc\Entities\Amc;
use RealEstate\Core\Location\Services\StateService;
use RealEstate\Core\Location\Validation\Definer\LocationDefiner;
use RealEstate\Core\Shared\Interfaces\EnvironmentInterface;
use RealEstate\Core\Shared\Validation\Rules\Phone;
use RealEstate\Core\Support\Service\ContainerInterface;
use RealEstate\Core\User\Services\UserService;
use RealEstate\Core\User\Validation\Inflators\EmailInflator;
use RealEstate\Core\User\Validation\Inflators\PasswordInflator;
use RealEstate\Core\User\Validation\Inflators\UsernameInflator;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class AmcValidator extends AbstractThrowableValidator
{
    /**
     * @var StateService
     */
    private $stateService;

    /**
     * @var UserService
     */
    private $userService;

    /**
     * @var EnvironmentInterface
     */
    private $environment;

    /**
     * @var Amc
     */
    private $currentAmc;

    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->stateService = $container->get(StateService::class);
        $this->userService = $container->get(UserService::class);
        $this->environment = $container->get(EnvironmentInterface::class);
    }

    /**
     * @param Binder $binder
     * @return void
     */
    protected function define(Binder $binder)
    {
        $binder->bind('companyName', function(Property $property){
            $property
                ->addRule(new Obligate())
                ->addRule(new Blank())
                ->addRule(new Length(1, 255));
        });

        $binder->bind('username', new UsernameInflator($this->userService, $this->environment, $this->currentAmc));
        $binder->bind('password', new PasswordInflator($this->environment));
        $binder->bind('email', new EmailInflator());

        (new LocationDefiner($this->stateService))->define($binder);

        $binder->bind('phone', function(Property $property){
            $property
                ->addRule(new Obligate())
                ->addRule(new Phone());
        });

        $binder->bind('fax', function(Property $property){
            $property->addRule(new Phone());
        });
    }

    /**
     * @param Amc $amc
     * @return $this
     */
    public function setCurrentAmc(Amc $amc)
    {
        $this->currentAmc = $amc;

        return $this;
    }
}