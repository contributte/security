# Security

## Content

- [Usage - how to register](#usage)
- [Authentication - list of authenticators](#authentication)

## Usage

As each extra functionality you should register this SecurityExtension.

```yaml
extensions:
    secured: Contributte\Security\DI\SecurityExtension(%debugMode%)
```

## Authentication

### DebugAuthenticator

```yaml
services:
    security.authenticator: Contributte\Security\Auth\DebugAuthenticator(true/false)
```

### StaticAuthenticator

```yaml
services:
    security.authenticator: Contributte\Security\Auth\StaticAuthenticator([
        "john@doe.net" => [
            password: $2y$10$fn.Y.EyNIaQwp1laEQskUOywXDbahvZ9xjWVaEQ4u2rDFj87F/YKO,
            identity: Nette\Security\Identity(
                "john@doe.net",
                ["user", "roles"],
                ["custom", "data"]
            )
        ]
    )
```

**Hint**

Don't know syntax for StaticAuthenticator identity?

`Nette\Security\Identity('id', ['role'], ['data'])` in neon is equivalent for `new Nette\Security\Identity(string $id, array $roles, array $data)` in php.
