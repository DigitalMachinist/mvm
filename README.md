# mvm

A tool for mapping out and analyzing 2D metroidvania games where progression depends on locks and keys.

## Getting started

```bash
git clone git@github.com:DigitalMachinist/mvm.git
git submodule update --init --recursive
./dup
./dbash
# We're now in the docker container's bash context.
composer install
exit
# We're now back in the host machine's terminal context.
```

## Laradock/Docker

This project uses [Laradock](https://laradock.io/) to host a local dev environment via docker.

When the docker container is running, visit [http://localhost](http://localhost) to open the app in the browser. You can start the docker container with the `./dup` command, which is outlined below.

*Note: I had to remove the --with-libzip argument from a line in ./laradock/php-fpm/Dockerfile to allow PHP 7.4 to be installed withour errors!*

The laradock project is linked as a submodule and can be updated/pulled using:

```bash
git submodule update --init --recursive
```

## Backend Stuff

This section covers a bunch of commands and notes regarding the backend configureation and features of the app.

Laravel IDE symbol maps are auto-generated on `composer update`.

### Bash commands

These bash commands exist as shorthands to the most common `docker-conpose` commands that I need to run on the docker container.

| Command | Description |
|---------|-------------|
| ./dup   | Start the docker container (begin hosting at [http://localhost](http://localhost)). |
| ./ddown | Stop the docker container. |
| ./dps   | List out the docker containers running in this network. |
| ./dlogs | Dump the docker logs. |
| ./dbash | Run bash within the docker container to execute terminal commands. |
| ./dtink | Run tinker within the docker container to REPL PHP commands. |
| ./dwork | Start Horizon running to handle queued jobs from Laravel. |

### Composer commands

These composer commands help with development tasks related to code quality and testing.

***Composer commands need to be run on the docker container, so run `./dbash` before executing any of these. Yes, this includes `composer install`, `composer update` and `composer dump-autoload`.***

| Command                     | Description |
|-----------------------------|-------------|
| composer run lint           | Perform style checks on the entire app. |
| composer run lint-all       | Perform style checks only on the current diff. |
| composer run psalm          | Perform static analysis on the app. |
| composer run update-symbols | Update the symbols used by psalm for code hinting. |

### Internal Dashboards

These dashboards are part of the app and are only live when the app is hosted.

| Dashboard   | URL |
|-------------|-----|
| Log Viewer  | [http://localhost/log-viewer](http://localhost/log-viewer) |
| Clockwork   | [http://localhost/__clockwork](http://localhost/__clockwork) |
| Horizon     | [http://localhost/horizon](http://localhost/horizon) |
| Telescope   | [http://localhost/telescope](http://localhost/telescope) |

### External Dashboards

These dashboards are offered by external services, so you'll need login creds to get to these.

| Dashboard   | URL |
|-------------|-----|
| Algolia     | [https://www.algolia.com/apps/Z0DB271DZ3/dashboard](https://www.algolia.com/apps/Z0DB271DZ3/dashboard) |
| Bugsnag     | [https://app.bugsnag.com/axon-interactive/mvm](https://app.bugsnag.com/axon-interactive/mvm) |
| Cloudinary  | [https://cloudinary.com/console/welcome](https://cloudinary.com/console/welcome) |
