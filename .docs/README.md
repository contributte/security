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
            identity: [
                id: "john@doe.net",
                roles: ["user", "roles"],
                data: ["custom", "data"]
            ]
        ]
    )
```

You can also use alternative syntax for identity with neon entity

```yaml
identity: Nette\Security\Identity(
    "john@doe.net",
    ["user", "roles"],
    ["custom", "data"]
)
```
