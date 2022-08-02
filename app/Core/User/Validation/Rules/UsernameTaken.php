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
class UsernameTaken extends AbstractRule
{

    /**
     *
     * @var UserService
     */
    private $userService;

    /**
     *
     * @var string
     */
    private $currentUsername;

    /**
     *
     * @param UserService $userService
     * @param string $currentUsername
     */
    public function __construct(UserService $userService, $currentUsername = null)
    {
        $this->userService = $userService;
        $this->currentUsername = $currentUsername;

        $this->setIdentifier('already-taken');
        $this->setMessage('Username is already taken.');
    }

    /**
     *
     * @param mixed|Value $value
     * @return Error|null
     */
    public function check($value)
    {
        if ($this->userService->existsWithUsername($value, $this->currentUsername)) {
            return $this->getError();
        }

        return null;
    }
}