<?php declare(strict_types = 1);

namespace Contributte\Security\Auth;

use Nette\Security\AuthenticationException;
use Nette\Security\Authenticator;
use Nette\Security\IIdentity;
use Nette\Security\SimpleIdentity;

class DebugAuthenticator implements Authenticator
{

	private ?IIdentity $identity = null;

	public function __construct(
		private readonly bool $pass = true,
	)
	{
	}

	public function setIdentity(IIdentity $identity): void
	{
		$this->identity = $identity;
	}

	public function authenticate(string $username, string $password): IIdentity
	{
		if ($this->pass === false) {
			throw new AuthenticationException('Cannot login', Authenticator::Failure);
		}

		if ($this->identity !== null) {
			return $this->identity;
		}

		return new SimpleIdentity(1);
	}

}
