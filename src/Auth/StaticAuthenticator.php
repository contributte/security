<?php declare(strict_types = 1);

namespace Contributte\Security\Auth;

use InvalidArgumentException;
use Nette\Security\AuthenticationException;
use Nette\Security\IAuthenticator;
use Nette\Security\Identity;
use Nette\Security\IIdentity;
use Nette\Security\Passwords;
use function is_string;

class StaticAuthenticator implements IAuthenticator
{

	/** @var array[] */
	private $list;

	/**
	 * @param array[] $list
	 * @throws InvalidArgumentException
	 */
	public function __construct(array $list)
	{
		foreach ($list as $username => $values) {

			// backward compatibility
			if (is_string($values)) {
				$this->list[$username] = [
					'password' => $values,
				];
				trigger_error('Usage of `$username => $password` is deprecated, use `$usernaname => ["password" => $password]` instead', E_USER_DEPRECATED);
				continue;
			}

			if (!isset($values['password'])) {
				throw new InvalidArgumentException(sprintf('Missing parameter `password` for user `%s`', $username));
			}

			$this->list[$username] = [
				'password' => $values['password'],
				'identity' => $values['identity'] ?? null,
			];

		}

	}

	/**
	 * @param array $credentials
	 * @return IIdentity
	 * @throws AuthenticationException
	 */
	public function authenticate(array $credentials): IIdentity
	{
		[$username, $password] = $credentials;

		if (!isset($this->list[$username])) {
			throw new AuthenticationException(sprintf('User `%s` not found', $username), IAuthenticator::IDENTITY_NOT_FOUND);
		}

		if (!Passwords::verify($password, $this->list[$username]['password'])) {
			throw new AuthenticationException('Invalid password', IAuthenticator::INVALID_CREDENTIAL);
		}

		/** @var IIdentity $identity */
		$identity = $this->list[$username]['identity'];

		// backward compatibility
		if ($identity === null) {
			return new Identity($username, null, ['username' => $username]);
		}

		return $this->list[$username]['identity'];
	}

}
