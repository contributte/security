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

// Success - hashed password
test(function (): void {
	$auth = new StaticAuthenticator([
		'foo@bar.baz' => [
			'password' => Passwords::hash('foobar'),
		],
	]);

	Assert::type(IIdentity::class, $auth->authenticate(['foo@bar.baz', 'foobar']));
});

// Success - plain password
test(function (): void {
	$auth = new StaticAuthenticator([
		'foo@bar.baz' => [
			'password' => 'foobar',
			'unsecured' => true,
		],
	]);

	Assert::type(IIdentity::class, $auth->authenticate(['foo@bar.baz', 'foobar']));
});

// Deprecated syntax
test(function (): void {
	Assert::error(function (): void {
		$auth = new StaticAuthenticator([
			'foo@bar.baz' => Passwords::hash('foobar'),
		]);

		$auth->authenticate(['foo@bar.baz', 'foobar']);
	}, E_USER_DEPRECATED, 'Usage of `$username => $password` is deprecated, use `$username => ["password" => $password]` instead');
});

// User not found
test(function (): void {
	$auth = new StaticAuthenticator([
		'foo@bar.baz' => [
			'password' => Passwords::hash('foobar'),
		],
	]);

	Assert::exception(function () use ($auth): void {
		$auth->authenticate(['foo', 'bar']);
	}, AuthenticationException::class, 'User `foo` not found');
});

// Invalid password
test(function (): void {
	$auth = new StaticAuthenticator([
		'foo@bar.baz' => [
			'password' => Passwords::hash('foobar'),
		],
	]);

	Assert::exception(function () use ($auth): void {
		$auth->authenticate(['foo@bar.baz', 'bar']);
	}, AuthenticationException::class, 'Invalid password');
});
