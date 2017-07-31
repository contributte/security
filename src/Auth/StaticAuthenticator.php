<?php

namespace Contributte\Security\Auth;

use Nette\Security\AuthenticationException;
use Nette\Security\IAuthenticator;
use Nette\Security\Identity;
use Nette\Security\IIdentity;
use Nette\Security\Passwords;

class StaticAuthenticator implements IAuthenticator
{

	/** @var array */
	private $list = [];

	/**
	 * @param array $list
	 */
	public function __construct(array $list)
	{
		$this->list = $list;
	}

	/**
	 * @param array $credentials
	 * @return IIdentity
	 * @throws AuthenticationException
	 */
	public function authenticate(array $credentials)
	{
		list ($username, $password) = $credentials;

		if (!isset($this->list[$username])) {
			throw new AuthenticationException(sprintf('User "%s" not found', $username), IAuthenticator::IDENTITY_NOT_FOUND);
		}

		if (!Passwords::verify($password, $this->list[$username])) {
			throw new AuthenticationException('Invalid password', IAuthenticator::INVALID_CREDENTIAL);
		}

		return new Identity($username, NULL, ['username' => $username]);
	}

}
