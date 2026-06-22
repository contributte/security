![](https://heatbadger.now.sh/github/readme/contributte/security/)

<p align=center>
  <a href="https://github.com/contributte/security/actions"><img src="https://badgen.net/github/checks/contributte/security/master?security=300"></a>
  <a href="https://coveralls.io/r/contributte/security"><img src="https://badgen.net/coveralls/c/github/contributte/security?security=300"></a>
  <a href="https://packagist.org/packages/contributte/security"><img src="https://badgen.net/packagist/dm/contributte/security"></a>
  <a href="https://packagist.org/packages/contributte/security"><img src="https://badgen.net/packagist/v/contributte/security"></a>
</p>
<p align=center>
  <a href="https://packagist.org/packages/contributte/security"><img src="https://badgen.net/packagist/php/contributte/security"></a>
  <a href="https://github.com/contributte/security"><img src="https://badgen.net/github/license/contributte/security"></a>
  <a href="https://bit.ly/ctteg"><img src="https://badgen.net/badge/support/gitter/cyan"></a>
  <a href="https://bit.ly/cttfo"><img src="https://badgen.net/badge/support/forum/yellow"></a>
  <a href="https://contributte.org/partners.html"><img src="https://badgen.net/badge/sponsor/donations/F96854"></a>
</p>

<p align=center>
Website 🚀 <a href="https://contributte.org">contributte.org</a> | Contact 👨🏻‍💻 <a href="https://f3l1x.io">f3l1x.io</a> | Twitter 🐦 <a href="https://twitter.com/contributte">@contributte</a>
</p>

Security helpers and authenticators for Nette applications.

## Versions

| State       | Version | Branch   | Nette | PHP     |
|-------------|---------|----------|-------|---------|
| dev         | `^0.5`  | `master` | 3.0+  | `>=7.2` |
| stable      | `^0.4`  | `master` | 3.0+  | `>=7.2` |
| stable      | `^0.2`  | `master` | 2.4   | `>=7.1` |

## Installation

To install latest version of `contributte/security` use [Composer](https://getcomposer.org).

```bash
composer require contributte/security
```

## Authenticators

### DebugAuthenticator

```neon
services:
	security.authenticator: Contributte\Security\Auth\DebugAuthenticator(true/false)
```

### StaticAuthenticator

```neon
services:
	security.authenticator: Contributte\Security\Auth\StaticAuthenticator([
		"john@doe.net":
			# password generated through Nette\Security\Passwords::hash()
			password: $2y$10$fn.Y.EyNIaQwp1laEQskUOywXDbahvZ9xjWVaEQ4u2rDFj87F/YKO
			identity: [
				id: john@doe.net
				roles: [user, roles]
				data: [custom, data]
			]
	])
```

**Usage without password hashing**

```neon
services:
	security.authenticator: Contributte\Security\Auth\StaticAuthenticator([
		"john@doe.net":
			# plain password
			password: foobar
			# check password as plain string
			unsecured: true
			identity: [
				id: john@doe.net
				roles: [user, roles]
				data: [custom, data]
			]
	])
```

**Usage with custom `Nette\Security\IIdentity` implementation**

```neon
services:
	security.authenticator: Contributte\Security\Auth\StaticAuthenticator([
		"john@doe.net":
			password: $2y$10$fn.Y.EyNIaQwp1laEQskUOywXDbahvZ9xjWVaEQ4u2rDFj87F/YKO
			identity: My\Own\Identity(
				john@doe.net,
				[user, roles],
				[custom, data]
			)
	])
```

## Development

See [how to contribute](https://contributte.org) to this package. This package is currently maintained by these authors.

<a href="https://github.com/f3l1x">
    <img width="80" height="80" src="https://avatars2.githubusercontent.com/u/538058?v=3&s=80">
</a>

-----

Consider to [support](https://contributte.org/partners) **contributte** development team.
Also thank you for using this package.
