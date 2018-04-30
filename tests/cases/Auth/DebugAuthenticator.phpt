<?php declare(strict_types = 1);

/**
 * Test: Auth\DebugAuthenticator
 */

require_once __DIR__ . '/../../bootstrap.php';

use Contributte\Security\Auth\DebugAuthenticator;
use Nette\Security\AuthenticationException;
use Nette\Security\IIdentity;
use Tester\Assert;

// Optimistic
test(function (): void {
	$auth = new DebugAuthenticator(true);
	Assert::type(IIdentity::class, $auth->authenticate(['foo', 'bar']));
});

// Pessimistic
test(function (): void {
	Assert::exception(function () {
		$auth = new DebugAuthenticator(false);
		$auth->authenticate([]);
	}, AuthenticationException::class);
});
