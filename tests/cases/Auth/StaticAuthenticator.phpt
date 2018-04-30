<?php declare(strict_types = 1);

/**
 * Test: Auth\StaticAuthenticator
 */

require_once __DIR__ . '/../../bootstrap.php';

use Contributte\Security\Auth\StaticAuthenticator;
use Nette\Security\AuthenticationException;
use Nette\Security\IIdentity;
use Nette\Security\Passwords;
use Tester\Assert;

// Success
test(function (): void {
	$auth = new StaticAuthenticator([
		'foo@bar.baz' => [
			'password' => Passwords::hash('foobar'),
		],
	]);

	Assert::type(IIdentity::class, $auth->authenticate(['foo@bar.baz', 'foobar']));
});

// User not found
test(function (): void {
	$auth = new StaticAuthenticator([
		'foo@bar.baz' => [
			'password' => Passwords::hash('foobar'),
		],
	]);

	Assert::exception(function () use ($auth) {
		$auth->authenticate(['foo', 'bar']);
	}, AuthenticationException::class, 'User "foo" not found');
});

// Invalid password
test(function (): void {
	$auth = new StaticAuthenticator([
		'foo@bar.baz' => [
			'password' => Passwords::hash('foobar'),
		],
	]);

	Assert::exception(function () use ($auth) {
		$auth->authenticate(['foo@bar.baz', 'bar']);
	}, AuthenticationException::class, 'Invalid password');
});
