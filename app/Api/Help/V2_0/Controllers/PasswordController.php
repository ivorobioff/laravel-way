<?php
namespace RealEstate\Api\Help\V2_0\Controllers;

use Restate\Libraries\Validation\Error;
use Restate\Libraries\Validation\ErrorsThrowableCollection;
use Illuminate\Http\Response;
use RealEstate\Api\Help\V2_0\Processors\PasswordChangeProcessor;
use RealEstate\Api\Help\V2_0\Processors\PasswordResetProcessor;
use RealEstate\Api\Support\BaseController;
use RealEstate\Core\User\Exceptions\EmailNotFoundException;
use RealEstate\Core\User\Exceptions\InvalidPasswordException;
use RealEstate\Core\User\Exceptions\InvalidTokenException;
use RealEstate\Core\User\Exceptions\UserNotFoundException;
use RealEstate\Core\User\Services\UserService;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class PasswordController extends BaseController
{
	/**
	 * @var UserService
	 */
	private $userService;

	/**
	 * @param UserService $userService
	 */
	public function initialize(UserService $userService)
	{
		$this->userService = $userService;
	}

	/**
	 * @param PasswordResetProcessor $processor
	 * @return Response
	 */
	public function reset(PasswordResetProcessor $processor)
	{
		try {
			$this->userService->requestResetPassword($processor->getUsername());
		} catch (UserNotFoundException $ex){
			$this->throwUsernameError('user-not-found', $ex->getMessage());
		} catch (EmailNotFoundException $ex){
			$this->throwUsernameError('email-not-found', $ex->getMessage());
		}

		return $this->resource->blank();
	}

	/**
	 * @param string $identifier
	 * @param string $message
	 */
	private function throwUsernameError($identifier, $message)
	{
		$errors = new ErrorsThrowableCollection();

		$errors['username'] = new Error($identifier, $message);

		throw $errors;
	}

	/**
	 * @param PasswordChangeProcessor $processor
	 * @return Response
	 */
	public function change(PasswordChangeProcessor $processor)
	{
		try {
			$this->userService->updatePasswordByToken($processor->getPassword(), $processor->getToken());
		} catch (InvalidPasswordException $ex){
			$errors = new ErrorsThrowableCollection();

			$errors['password'] = new Error('invalid', $ex->getMessage());

			throw $errors;
		} catch (InvalidTokenException $ex){
			$errors = new ErrorsThrowableCollection();

			$errors['token'] = new Error('invalid', $ex->getMessage());

			throw $errors;
		}

		return $this->resource->blank();
	}
}