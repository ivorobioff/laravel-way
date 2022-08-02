<?php
namespace RealEstate\Core\User\Validation\Rules;

use Restate\Libraries\Validation\Error;
use Restate\Libraries\Validation\Rules\AbstractRule;
use Restate\Libraries\Validation\Value;
use RealEstate\Core\User\Services\UserService;

/**
 *
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class UserExists extends AbstractRule
{
    /**
     * @var UserService
     */
    private $userService;

    /**
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;

        $this->setMessage('User does not exist.');
        $this->setIdentifier('does-not-exist');
    }

    /**
     *
     * @param mixed|Value $value
     * @return Error|null
     */
    public function check($value)
    {
        if (! $this->userService->exists($value)) {
            return $this->getError();
        }

        return null;
    }
}