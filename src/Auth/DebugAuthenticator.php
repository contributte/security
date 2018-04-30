<?php declare(strict_types = 1);

namespace Contributte\Security\Auth;

use Nette\Security\AuthenticationException;
use Nette\Security\IAuthenticator;
use Nette\Security\Identity;
use Nette\Security\IIdentity;

class DebugAuthenticator implements IAuthenticator
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
	 * @param string[] $credentials
	 * @throws AuthenticationException
	 */
	public function authenticate(array $credentials): IIdentity
	{
		if ($this->pass === false) {
			throw new AuthenticationException('Cannot login', IAuthenticator::FAILURE);
		}

		if ($this->identity !== null) {
			return $this->identity;
		}

		return new Identity(1, null, null);
	}

}
