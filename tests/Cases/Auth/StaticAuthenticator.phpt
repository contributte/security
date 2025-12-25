<?php declare(strict_types = 1);

/**
 * Test: Auth\StaticAuthenticator
 */

require_once __DIR__ . '/../../bootstrap.php';

use Contributte\Security\Auth\StaticAuthenticator;
use Contributte\Tester\Toolkit;
use Nette\Security\AuthenticationException;
use Nette\Security\IIdentity;
use Nette\Security\Passwords;
use Tester\Assert;

// Authenticate with hashed password
Toolkit::test(function (): void {
	$hash = (new Passwords(PASSWORD_BCRYPT))->hash('foobar');
	$auth = new StaticAuthenticator([
		'foo@bar.baz' => [
			'password' => $hash,
		],
	], new Passwords(PASSWORD_BCRYPT));

	Assert::type(IIdentity::class, $auth->authenticate('foo@bar.baz', 'foobar'));
});

// Authenticate with plain password (unsecured)
Toolkit::test(function (): void {
	$auth = new StaticAuthenticator([
		'foo@bar.baz' => [
			'password' => 'foobar',
			'unsecured' => true,
		],
	], new Passwords(PASSWORD_BCRYPT));

	Assert::type(IIdentity::class, $auth->authenticate('foo@bar.baz', 'foobar'));
});

// Authenticate throws exception when user not found
Toolkit::test(function (): void {
	$hash = (new Passwords(PASSWORD_BCRYPT))->hash('foobar');
	$auth = new StaticAuthenticator([
		'foo@bar.baz' => [
			'password' => $hash,
		],
	], new Passwords(PASSWORD_BCRYPT));

	Assert::exception(function () use ($auth): void {
		$auth->authenticate('foo', 'bar');
	}, AuthenticationException::class, 'User `foo` not found');
});

// Authenticate throws exception on invalid password
Toolkit::test(function (): void {
	$hash = (new Passwords(PASSWORD_BCRYPT))->hash('foobar');
	$auth = new StaticAuthenticator([
		'foo@bar.baz' => [
			'password' => $hash,
		],
	], new Passwords(PASSWORD_BCRYPT));

	Assert::exception(function () use ($auth): void {
		$auth->authenticate('foo@bar.baz', 'bar');
	}, AuthenticationException::class, 'Invalid password');
});
