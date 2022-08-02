<?php
namespace RealEstate\Core\Session\Validation;

use Restate\Libraries\Validation\AbstractThrowableValidator;
use Restate\Libraries\Validation\Binder;
use Restate\Libraries\Validation\Property;
use Restate\Libraries\Validation\Rules\Blank;
use Restate\Libraries\Validation\Rules\Obligate;
use RealEstate\Core\Support\Service\ContainerInterface;
use RealEstate\Core\User\Services\UserService;
use RealEstate\Core\User\Validation\Rules\Access;

/**
 *
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class CredentialsValidator extends AbstractThrowableValidator
{

    /**
     * @var ContainerInterface
     */
    private $userService;

    /**
     *
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     *
     * @param Binder $binder
     */
    protected function define(Binder $binder)
    {
        $binder->bind('username', function (Property $property) {

            $property->addRule(new Obligate())
                ->addRule(new Blank());
        });

        $binder->bind('password', function (Property $property) {

            $property->addRule(new Obligate())
                ->addRule(new Blank());
        });

        $binder->bind('credentials', ['username', 'password'], function (Property $property) {
            $property->addRule(new Access($this->userService));
        });
    }
}