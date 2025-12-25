<?php declare(strict_types = 1);

/**
 * Test: Auth\DebugAuthenticator
 */

require_once __DIR__ . '/../../bootstrap.php';

use Contributte\Security\Auth\DebugAuthenticator;
use Contributte\Tester\Toolkit;
use Nette\Security\AuthenticationException;
use Nette\Security\IIdentity;
use Tester\Assert;

// Authenticate with pass=true returns identity
Toolkit::test(function (): void {
	$auth = new DebugAuthenticator(true);
	Assert::type(IIdentity::class, $auth->authenticate('foo', 'bar'));
});

// Authenticate with pass=false throws exception
Toolkit::test(function (): void {
	Assert::exception(function (): void {
		$auth = new DebugAuthenticator(false);
		$auth->authenticate('', '');
	}, AuthenticationException::class);
});
