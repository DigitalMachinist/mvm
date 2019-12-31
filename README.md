# mvm

A tool for mapping out and analyzing 2D metroidvania games where progression depends on locks and keys.

## Getting started

```bash
git clone git@github.com:DigitalMachinist/mvm.git
git submodule update --init --recursive
./dup
./dinstall
./dcreatekey
./dtestdatabase
```

Copy `.env.example` to `.env`.

Visit `http://localhost` in your browser.

You're good to go!

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

| Command         | Description |
|-----------------|-------------|
| danalyze        | Run static analysis on the whole app. |
| dannotate       | Update code symbols for use by pslam and Intelliphense. |
| dbash           | Open a bash terminal within the docker container to execute bash commands. |
| dcreatedatabase | Create a new database and run migrations. |
| dcreatekey      | Generate a new application key. |
| ddown           | Stop the docker container. |
| dhorizon        | Start Horizon within the docker container to process queued jobs for all queues. |
| dinstall        | Composer install within the docker container to fetch dependencies.
| dinstallquiet   | Composer install withing the docker conttainer to fetch dependencies silently and non-interactively. |
| dlint           | Style guide validate only the current diff. |
| dlinteverything | Style guide validate the whole app. |
| dlist           | List out the docker containers running in this network. |
| dlogs           | Display the docker network logs. |
| dmysql          | Open a mysql terminal within the docker container to execute SQL commamnds. |
| dredis          | Open a redis terminal within the docker container to execute Redis commamnds. |
| dtest           | Run phpunit tests on the whole app. |
| dtinker         | Open an artisan tinker terminal within the docker container to execute PHP commands. |
| dup             | Start the docker container (begin hosting at [http://localhost](http://localhost)). |

### Dashboards

These dashboards are part of the app and are only live when the app is hosted.

| Dashboard   | URL |
|-------------|-----|
| Log Viewer  | [http://localhost/log-viewer](http://localhost/log-viewer) |
| Clockwork   | [http://localhost/__clockwork](http://localhost/__clockwork) |
| Horizon     | [http://localhost/horizon](http://localhost/horizon) |
| Telescope   | [http://localhost/telescope](http://localhost/telescope) |

These dashboards are offered by external services, so you'll need login creds to get to these.

| Dashboard   | URL |
|-------------|-----|
| Algolia     | [https://www.algolia.com/apps/Z0DB271DZ3/dashboard](https://www.algolia.com/apps/Z0DB271DZ3/dashboard) |
| Bugsnag     | [https://app.bugsnag.com/axon-interactive/mvm](https://app.bugsnag.com/axon-interactive/mvm) |
| Cloudinary  | [https://cloudinary.com/console/welcome](https://cloudinary.com/console/welcome) |

### Local MySQL Connection

To connect to `mysqld` within the docker container from your host machine, use the following creds in **Sequel Pro** or whatever:

```env
DB_HOST=0.0.0.0
DB_PORT=13306
DB_DATABASE=mvm
DB_USERNAME=root
DB_PASSWORD=root
```

### Local Redis Connection

To connect to `redis` within the docker container from your host machine, use the following creds in **RDM** or whatever:

```env
REDIS_HOST=0.0.0.0
REDIS_PORT=16379
```
