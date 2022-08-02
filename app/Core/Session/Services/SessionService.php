<?php
namespace RealEstate\Core\Session\Services;

use RealEstate\Core\Session\Entities\Session;
use RealEstate\Core\Session\Interfaces\SessionPreferenceInterface;
use RealEstate\Core\Shared\Interfaces\TokenGeneratorInterface;
use RealEstate\Core\Session\Validation\CredentialsValidator;
use RealEstate\Core\Support\Service\AbstractService;
use RealEstate\Core\User\Entities\Token;
use RealEstate\Core\User\Entities\User;
use RealEstate\Core\User\Enums\Intent;
use RealEstate\Core\User\Exceptions\InvalidTokenException;
use RealEstate\Core\User\Exceptions\UserNotFoundException;
use RealEstate\Core\User\Objects\Credentials;
use RealEstate\Core\User\Services\UserService;
use DateTime;
use DomainException;

/**
 *
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class SessionService extends AbstractService
{
	/**
	 * @var SessionPreferenceInterface
	 */
	private $preference;

	/**
	 * @var TokenGeneratorInterface
	 */
	private $generator;

	/**
	 * @param SessionPreferenceInterface $preference
	 * @param TokenGeneratorInterface $generator
	 */
	public function initialize(SessionPreferenceInterface $preference, TokenGeneratorInterface $generator)
	{
		$this->preference = $preference;
		$this->generator = $generator;
	}

	/**
	 * @param string $token
	 * @return Session
	 */
	public function createWithAutoLoginToken($token)
	{
		/**
		 * @var Token $token
		 */
		$token = $this->entityManager->getRepository(Token::class)
			->retrieve([
				'value' => $token,
				'expiresAt' => ['>', new DateTime()],
				'intent' => Intent::AUTO_LOGIN
			]);

		if ($token === null){
			throw new InvalidTokenException();
		}

		$session = $this->createInMemoryWithUser($token->getUser());

		$this->entityManager->remove($token);
        $this->entityManager->persist($session);
        $this->entityManager->flush();

		return $session;
	}

    /**
     * @param Credentials $credentials
     * @return Session
     */
    public function create(Credentials $credentials)
    {
        /**
         * @var UserService $userService
         */
        $userService = $this->container->get(UserService::class);

        (new CredentialsValidator($userService))->validate($credentials);

        $session = $this->createInMemoryWithUser($userService->getAuthorized($credentials));

		$this->entityManager->persist($session);
		$this->entityManager->flush();

		return $session;
    }

	/**
	 * @param User $user
	 * @return Session
	 */
	private function createInMemoryWithUser(User $user)
	{
		$session = new Session();
		$session->setCreatedAt(new DateTime());
		$session->setExpireAt(new DateTime('+' . $this->preference->getLifetime().' minutes'));

		$session->setToken($this->generator->generate());

		$session->setUser($user);

		return $session;
	}

    /**
     * @param int $id
     * @return Session
     * @throws DomainException
     */
    public function refresh($id)
    {
        $session = $this->get($id);

        if (! $session) {
            throw new DomainException('The session with the "' . $id . '" ID cannot be refreshed since it has not been found.');
        }


        $session->setToken($this->generator->generate());
        $session->getExpireAt()->modify('+' . $this->preference->getLifetime() . ' minutes');

        $this->entityManager->persist($session);
        $this->entityManager->flush();

        return $session;
    }

    /**
     * @param int $id
     * @return Session|null
     */
    public function get($id)
    {
        return $this->entityManager->find(Session::class, $id);
    }

    /**
     * @param string $token
     * @return Session|null
     */
    public function getByToken($token)
    {
        $repository = $this->entityManager->getRepository(Session::class);
        return $repository->findOneBy(['token' => $token]);
    }

    /**
     * @param int $id
     */
    public function delete($id)
    {
		/**
		 * @var Session $session
		 */
		$session = $this->entityManager->getReference(Session::class, $id);

		$this->entityManager->remove($session);
		$this->entityManager->flush();
    }

    /**
     * @param int $userId
     */
    public function deleteAllByUserId($userId)
    {
		$this->entityManager->getRepository(Session::class)->delete(['user' => $userId]);
    }

    /**
     * @param int $id
     * @return bool
     */
    public function exists($id)
    {
		return $this->entityManager->getRepository(Session::class)->exists(['id' => $id]);
    }

    /**
     * @param int $sessionId
     * @param int $userId
     * @return bool
     */
    public function verifyOwner($sessionId, $userId)
    {
		return $this->entityManager->getRepository(Session::class)
			->exists(['id' => $sessionId, 'user' => $userId]);
    }

	public function deleteAllExpired()
	{
		$this->entityManager->getRepository(Session::class)->delete([
			'expireAt' => ['<', new DateTime()]
		]);
	}

	/**
	 * @param int $userId
	 * @return Token
	 */
	public function createAutoLoginToken($userId)
	{
		/**
		 * @var User $user
		 */
		$user = $this->entityManager->find(User::class, $userId);

		if ($user === null){
			throw new UserNotFoundException();
		}

		$token = new Token();

		$token->setIntent(new Intent(Intent::AUTO_LOGIN));
		$token->setUser($user);
		$token->setCreatedAt(new DateTime());
		$token->setExpiresAt(new DateTime('+'.$this->preference->getAutoLoginTokenLifetime().' minutes'));
		$token->setValue($this->generator->generate());

		$this->entityManager->persist($token);
		$this->entityManager->flush();

		return $token;
	}

	/**
	 * Creates session for system user
	 *
	 * @return Session
	 */
	public function createSystem()
	{
		/**
		 * @var UserService $userService
		 */
		$userService = $this->container->get(UserService::class);

		$session = $this->createInMemoryWithUser($userService->getSystem());

		$this->entityManager->persist($session);
		$this->entityManager->flush();

		return $session;
	}

	/**
	 * Deletes session for system user
	 */
	public function deleteSystem()
	{
		/**
		 * @var UserService $userService
		 */
		$userService = $this->container->get(UserService::class);

		$system = $userService->getSystem();

		$this->deleteAllByUserId($system->getId());
	}
}