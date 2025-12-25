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

	/** @var array<string, array{password: string, unsecured: bool, identity: IIdentity}> */
	private array $list = [];

	/**
	 * @param array<string, array<string, mixed>> $list
	 */
	public function __construct(
		array $list,
		private readonly Passwords $passwords,
	)
	{
		foreach ($list as $username => $values) {
			if (!isset($values['password'])) {
				throw new InvalidArgumentException(sprintf('Missing parameter `password` for user `%s`', $username));
			}

			if (!is_string($values['password'])) {
				throw new InvalidArgumentException(sprintf('Password for user `%s` must be a string', $username));
			}

			$this->list[$username] = [
				'password' => $values['password'],
				'unsecured' => (bool) ($values['unsecured'] ?? false),
				'identity' => $this->createIdentity($username, $values),
			];
		}
	}

	public function authenticate(string $username, string $password): IIdentity
	{
		if (!isset($this->list[$username])) {
			throw new AuthenticationException(sprintf('User `%s` not found', $username), Authenticator::IdentityNotFound);
		}

		$user = $this->list[$username];

		if (
			($user['unsecured'] === true && !hash_equals($password, $user['password'])) ||
			($user['unsecured'] === false && !$this->passwords->verify($password, $user['password']))
		) {
			throw new AuthenticationException('Invalid password', Authenticator::InvalidCredential);
		}

		return $user['identity'];
	}

	/**
	 * @param array<string, mixed> $values
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

		if (is_array($identity)) {
			$id = $identity['id'] ?? $username;
			$roles = $identity['roles'] ?? null;
			$data = $identity['data'] ?? null;

			return new SimpleIdentity(
				is_scalar($id) ? (string) $id : $username,
				is_array($roles) ? $roles : null,
				is_array($data) ? $data : null
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
