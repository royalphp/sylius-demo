# General examples for Sylius eCommerce by RoyalPHP

This demo project is based on the Sylius FrankenPHP Edition by RoyalPHP.

![Starting point for Sylius eCommerce powered by FrankenPHP](docs/frankenphp-sylius-logo.png)

## About

A [Docker](https://docker.com)-based installer and runtime for the
[Sylius](http://sylius.com) eCommerce platform with
[FrankenPHP](https://frankenphp.dev) and [Caddy](https://caddyserver.com) inside!

![CI](https://github.com/royalphp/sylius-demo/workflows/CI/badge.svg)

## Libraries

The following third-party libraries are used in this demo repository:

1. [SyliusBootstrapTheme](https://github.com/royalphp/sylius-bootstrap-theme)

## Versions

| Branch | Tag     | Sylius  | Symfony | PHP    |
|--------|---------|---------|---------|--------|
| `2.x`  | `0.2.*` | `^2.0`  | `^7.2`  | `^8.3` |
| `1.x`  | `0.1.*` | `^1.14` | `^6.4`  | `^8.3` |

## Getting Started

All control is via `Makefile`. To see all available commands, run `make`.
For a quick start, execute the following command:

```shell
make setup
```

Under the hood, this command executes the commands needed to run your project
for the first time. You won't need it again unless you want to reconfigure the
project. After successful execution, open `https://localhost` in your browser.

By default, you are working in a development environment, so `make` commands do
not require additional options. To deploy the project or run a command in
production, specify the `PROJECT_MODE=prod` option.

## Documentation

Documentation for "Symfony Docker" is available in the
[*docs/symfony-docker*](docs/symfony-docker/index.md) folder.

Documentation for "FrankenPHP" is available at [frankenphp.dev/docs](https://frankenphp.dev/docs).

Documentation for "Sylius" is available at [docs.sylius.com](http://docs.sylius.com).

## Bug Tracking

If you want to report a bug or suggest an idea, please use [GitHub issues](https://github.com/royalphp/sylius-demo/issues).

## License

This theme uses [MIT License](LICENSE).

## Authors

The theme was originally created by [RoyalPHP](https://github.com/royalphp).
See the list of [contributors](https://github.com/royalphp/sylius-demo/contributors).
