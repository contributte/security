<?php

/**
 * Test: Auth\DebugAuthenticator
 */

require_once __DIR__ . '/../../bootstrap.php';

use Contributte\Security\Auth\DebugAuthenticator;
use Nette\Security\AuthenticationException;
use Nette\Security\IIdentity;
use Tester\Assert;

// Optimistic
test(function () {
	$auth = new DebugAuthenticator(TRUE);
	Assert::type(IIdentity::class, $auth->authenticate(['foo', 'bar']));
});

// Pessimistic
test(function () {
	Assert::exception(function () {
		$auth = new DebugAuthenticator(FALSE);
		$auth->authenticate([]);
	}, AuthenticationException::class);
});
