<?php
namespace RealEstate\Core\User\Validation\Rules;

use Restate\Libraries\Validation\Value;
use RealEstate\Core\User\Services\UserService;
use RealEstate\Core\User\Objects\Credentials;
use Restate\Libraries\Validation\Rules\AbstractRule;

/**
 * The rule checks whether with the provided password the user can login under the provided username
 *
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class Access extends AbstractRule
{

    /**
     *
     * @var UserService $userService
     */
    private $userService;

    /**
     *
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;

        $this->setIdentifier('access');
        $this->setMessage('The user with the provided credentials cannot be found.');
    }

    /**
     *
     * @param Value $value
     * @return bool
     */
    public function check($value)
    {
        list ($username, $password) = $value->extract();

        $credentials = new Credentials();
        $credentials->setUsername($username);
        $credentials->setPassword($password);

        if (! $this->userService->canAuthorize($credentials)) {
            return $this->getError();
        }

        return null;
    }
}