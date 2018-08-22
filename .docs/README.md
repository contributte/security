# Security

## Content

- [Usage - how to register](#usage)
- [Configuration - how to configure](#configuration)
- [Authentication - list of authenticators](#authentication)

## Usage

As with any other extension, you need to register it.

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

**Usage without password hashing**

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

**Usage with custom `Nette\Security\IIdentity` implementation **

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
