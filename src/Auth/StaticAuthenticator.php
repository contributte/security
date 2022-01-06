<?php declare(strict_types = 1);

namespace Contributte\Security\Auth;

use InvalidArgumentException;
use Nette\Security\AuthenticationException;
use Nette\Security\Authenticator;
use Nette\Security\IIdentity;
use Nette\Security\Passwords;
use Nette\Security\SimpleIdentity;

class StaticAuthenticator implements Authenticator
{

	/** @var mixed[][] */
	private $list;

	/** @var Passwords */
	private $passwords;

	/**
	 * @param mixed[] $list
	 * @throws InvalidArgumentException
	 */
	public function __construct(array $list, Passwords $passwords)
	{
		foreach ($list as $username => $values) {
			if (!isset($values['password'])) {
				throw new InvalidArgumentException(sprintf('Missing parameter `password` for user `%s`', $username));
			}

			$this->list[$username] = [
				'password' => $values['password'],
				'unsecured' => $values['unsecured'] ?? false,
				'identity' => $this->createIdentity($username, $values),
			];
		}

		$this->passwords = $passwords;
	}

	/**
	 * @throws AuthenticationException
	 */
	public function authenticate(string $username, string $password): IIdentity
	{
		if (!isset($this->list[$username])) {
			throw new AuthenticationException(sprintf('User `%s` not found', $username), Authenticator::IDENTITY_NOT_FOUND);
		}

		$user = $this->list[$username];

		if (
			($user['unsecured'] === true && !hash_equals($password, $user['password'])) ||
			($user['unsecured'] === false && !$this->passwords->verify($password, $user['password']))
		) {
			throw new AuthenticationException('Invalid password', Authenticator::INVALID_CREDENTIAL);
		}

		return $user['identity'];
	}

	/**
	 * @param mixed[] $values
	 */
	private function createIdentity(string $username, array $values): IIdentity
	{
		if (!isset($values['identity'])) {
			return new SimpleIdentity($username);
		}

		$identity = $values['identity'];

		if ($identity instanceof IIdentity) {
			return $identity;
		}

		if (is_array($values['identity'])) {
			return new SimpleIdentity(
				$identity['id'] ?? $username,
				$identity['roles'] ?? null,
				$identity['date'] ?? null
			);
		}

		throw new InvalidArgumentException(sprintf(
			'Identity of user `%s` must be `%s`, `%s` or `%s`.',
			$username,
			IIdentity::class,
			'array',
			'null'
		));
	}

}
