<?php
namespace RealEstate\Core\User\Validation\Inflators;
use Restate\Libraries\Validation\Property;
use Restate\Libraries\Validation\Rules\Blank;
use Restate\Libraries\Validation\Rules\Obligate;
use RealEstate\Core\Shared\Interfaces\EnvironmentInterface;
use RealEstate\Core\User\Entities\User;
use RealEstate\Core\User\Services\UserService;
use RealEstate\Core\User\Validation\Rules\Username;
use RealEstate\Core\User\Validation\Rules\UsernameTaken;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class UsernameInflator
{
    /**
     * @var EnvironmentInterface
     */
    private $environment;

    /**
     * @var UserService
     */
    private $userService;

    /**
     * @var User
     */
    private $currentUser;

    /**
     * @param UserService $userService
     * @param EnvironmentInterface $environment
     * @param User $currentUser
     */
    public function __construct(UserService $userService, EnvironmentInterface $environment, User $currentUser = null)
    {
        $this->userService = $userService;
        $this->environment = $environment;
        $this->currentUser = $currentUser;
    }


    public function __invoke(Property $property)
    {
        $property
            ->addRule(new Obligate())
            ->addRule(new UsernameTaken($this->userService, object_take($this->currentUser, 'username')));

        if (!$this->environment->isRelaxed()){
            $property->addRule(new Username());
        } else {
            $property->addRule(new Blank());
        }
    }
}