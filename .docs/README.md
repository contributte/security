# Security

## Content

- [Usage - how to register](#usage)
- [Authentication - list of authenticators](#authentication)

## Usage

As each extra functionality you should register this SecurityExtension.

```yaml
extensions:
    secured: Contributte\Security\DI\SecurityExtension
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
        "john@doe.net" => "$2y$10$WRJHd2kC77n46.sb5sgliuYeXbnQ0qK9WWRK8u0sy6lTHk5hNu/y2"]
    )
```
