<?php declare(strict_types = 1);

namespace Contributte\Security\Auth;

use Nette\Security\AuthenticationException;
use Nette\Security\Authenticator;
use Nette\Security\IIdentity;
use Nette\Security\SimpleIdentity;

class DebugAuthenticator implements Authenticator
{

	/** @var bool */
	private $pass;

	/** @var IIdentity|null */
	private $identity;

	public function __construct(bool $pass = true)
	{
		$this->pass = $pass;
	}

	public function setIdentity(IIdentity $identity): void
	{
		$this->identity = $identity;
	}

	/**
	 * @throws AuthenticationException
	 */
	public function authenticate(string $username, string $password): IIdentity
	{
		if ($this->pass === false) {
			throw new AuthenticationException('Cannot login', Authenticator::FAILURE);
		}

		if ($this->identity !== null) {
			return $this->identity;
		}

		return new SimpleIdentity(1, null, null);
	}

}
