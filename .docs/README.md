# Security

## Content

- [Usage - how to register](#usage)
- [Configuration - how to configure](#configuration)
- [Authentication - list of authenticators](#authentication)

## Usage

As each extra functionality you should register this SecurityExtension.

```yaml
extensions:
    secured: Contributte\Security\DI\SecurityExtension
```

## Configuration

```yaml
secured:
    debug: %debugMode%
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
            # password generated through Nette\Security\Passwords::hash()
            password: $2y$10$fn.Y.EyNIaQwp1laEQskUOywXDbahvZ9xjWVaEQ4u2rDFj87F/YKO,
            identity: [
                id: "john@doe.net",
                roles: ["user", "roles"],
                data: ["custom", "data"]
            ]
        ]
    )
```

**Usage without hashing of passwords**

```yaml
services:
    security.authenticator: Contributte\Security\Auth\StaticAuthenticator([
        "john@doe.net" => [
            # plain password
            password: 'foobar',
            # check password as plain string
            unsecured: true,
            identity: [
                id: "john@doe.net",
                roles: ["user", "roles"],
                data: ["custom", "data"]
            ]
        ]
    )
```

**Usage of own `Nette\Security\IIdentity`**

```yaml
services:
    security.authenticator: Contributte\Security\Auth\StaticAuthenticator([
        "john@doe.net" => [
            password: $2y$10$fn.Y.EyNIaQwp1laEQskUOywXDbahvZ9xjWVaEQ4u2rDFj87F/YKO,
            identity: My\Own\Identity(
                "john@doe.net",
                ["user", "roles"],
                ["custom", "data"]
            )
```
