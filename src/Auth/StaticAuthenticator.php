<?php declare(strict_types = 1);

namespace Contributte\Security\Auth;

use InvalidArgumentException;
use Nette\Security\AuthenticationException;
use Nette\Security\IAuthenticator;
use Nette\Security\Identity;
use Nette\Security\IIdentity;
use Nette\Security\Passwords;
use function is_array;
use function is_string;

class StaticAuthenticator implements IAuthenticator
{

	/** @var mixed[][] */
	private $list;

	/**
	 * @param mixed[] $list
	 * @throws InvalidArgumentException
	 */
	public function __construct(array $list)
	{
		foreach ($list as $username => $values) {

			// backward compatibility
			if (is_string($values)) {
				$this->list[$username] = [
					'password' => $values,
					'unsecured' => false,
					'identity' => new Identity($username, null, ['username' => $username]),
				];
				trigger_error('Usage of `$username => $password` is deprecated, use `$username => ["password" => $password]` instead', E_USER_DEPRECATED);
				continue;
			}

			if (!isset($values['password'])) {
				throw new InvalidArgumentException(sprintf('Missing parameter `password` for user `%s`', $username));
			}

			$this->list[$username] = [
				'password' => $values['password'],
				'unsecured' => $values['unsecured'] ?? false,
				'identity' => $this->createIdentity($username, $values),
			];

		}
	}

	/**
	 * @param string[] $credentials
	 * @throws AuthenticationException
	 */
	public function authenticate(array $credentials): IIdentity
	{
		[$username, $password] = $credentials;

		if (!isset($this->list[$username])) {
			throw new AuthenticationException(sprintf('User `%s` not found', $username), IAuthenticator::IDENTITY_NOT_FOUND);
		}

		$user = $this->list[$username];
		if (
			($user['unsecured'] === true && !hash_equals($password, $user['password'])) ||
			($user['unsecured'] === false && !Passwords::verify($password, $user['password']))
		) {
			throw new AuthenticationException('Invalid password', IAuthenticator::INVALID_CREDENTIAL);
		}

		return $user['identity'];
	}

	/**
	 * @param mixed[] $values
	 */
	private function createIdentity(string $username, array $values): IIdentity
	{
		if (!isset($values['identity'])) {
			return new Identity($username);
		}

		$identity = $values['identity'];

		if ($identity instanceof IIdentity) {
			return $identity;
		}

		if (is_array($values['identity'])) {
			return new Identity(
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
