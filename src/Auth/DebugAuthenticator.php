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

	/** @var IIdentity */
	private $identity;

	/**
	 * @param bool $pass
	 */
	public function __construct(bool $pass = true)
	{
		$this->pass = $pass;
	}

	/**
	 * @param IIdentity $identity
	 * @return void
	 */
	public function setIdentity(IIdentity $identity): void
	{
		$this->identity = $identity;
	}

	/**
	 * @param array $credentials
	 * @return IIdentity
	 * @throws AuthenticationException
	 */
	public function authenticate(array $credentials): IIdentity
	{
		if (!$this->pass) {
			throw new AuthenticationException('Cannot login', IAuthenticator::FAILURE);
		}

		if ($this->identity) {
			return $this->identity;
		}

		return new Identity(1, null, null);
	}

}
