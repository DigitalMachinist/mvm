# mvm

A tool for mapping out and analyzing 2D metroidvania games where progression depends on locks and keys.

## Getting started

### Check out the project

```bash
git clone git@github.com:DigitalMachinist/mvm.git
cp .env.example .env
```

### Spin up the backend

After completing the steps above to check out the project files:

```bash
./dup
./dinstall
./dcreatekey
./dcreatedatabase
```

Visit `http://localhost` in your browser to confirm the backend is being hosted.

### Spin up the frontend

After complting the steps above to get the backend working:

```bash
./dnuxtinstall
./dnuxtdev
```

Visit `http://localhost:3000` in your browser to confirm the frontend is being hosted.

## Laradock/Docker

This project uses [Laradock](https://laradock.io/) to host a local dev environment via docker.

When the docker container is running, visit [http://localhost](http://localhost) to open the app in the browser. You can start the docker container with the `./dup` command, which is outlined below.

*Note: I had to remove the --with-libzip argument from a line in ./laradock/php-fpm/Dockerfile to allow PHP 7.4 to be built withour errors!*

*Note: I had to add a port export of `3000:3000` to the workspace container's docker-compose.yml to allow the host machine to view the frontend at [http://localhost:3000](http://localhost:3000).*

## Bash commands

These bash commands exist as shorthands to the most common `docker-compose` commands that I need to run on the docker container.

***If you run composer/artisan/etc commands outside of the docker container you can expect to have problems! Use these!***

| Command         | Interactive? | Description |
|-----------------|--------------|-------------|
| danalyze        | No           | Run static analysis on the whole app. |
| dannotate       | No           | Update code symbols for use by pslam and Intelliphense. |
| dbash           | Yes          | Open a bash terminal within the docker container to execute bash commands. |
| dcreatedatabase | No           | Create a new database and run migrations. |
| dcreatekey      | No           | Generate a new application key. |
| ddown           | No           | Stop the docker container. |
| dhorizon        | Yes          | Start Horizon within the docker container to process queued jobs for all queues. |
| dinstall        | No           | Composer install within the docker container to fetch dependencies.
| dinstallquiet   | No           | Composer install withing the docker conttainer to fetch dependencies silently and non-interactively. |
| dlint           | No           | Style guide validate PHP files only from the current diff. |
| dlinteverything | No           | Style guide validate PHP files across the whole app. |
| dlist           | No           | List out the docker containers running in this network. |
| dlogs           | No           | Display the docker network logs. |
| dmysql          | Yes          | Open a mysql terminal within the docker container to execute SQL commamnds. |
| dnuxtbuild      | No           | Build the nuxt frontend app files. |
| dnuxtdev        | Yes          | Build & start the nuxt frontend app (begin hosting the frontend at [http://localhost:3000](http://localhost:3000)) and watch for changes. |
| dnuxtlint       | No           | Style guide validate nuxt frontend files. |
| dnuxtstart      | Yes          | Start the nuxt frontend app (begin hosting the frontend at [http://localhost:3000](http://localhost:3000)). |
| dredis          | Yes          | Open a redis terminal within the docker container to execute Redis commamnds. |
| dtest           | No           | Run phpunit tests on the whole app. |
| dtinker         | Yes          | Open an artisan tinker terminal within the docker container to execute PHP commands. |
| dup             | No           | Start the docker container (begin hosting the backend at [http://localhost](http://localhost)). |

## Dashboards

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

## Local MySQL Connection

To connect to `mysqld` within the docker container from your host machine, use the following creds in **Sequel Pro** or whatever:

```env
DB_HOST=0.0.0.0
DB_PORT=13306
DB_DATABASE=mvm
DB_USERNAME=root
DB_PASSWORD=root
```

## Local Redis Connection

To connect to `redis` within the docker container from your host machine, use the following creds in **RDM** or whatever:

```env
REDIS_HOST=0.0.0.0
REDIS_PORT=16379
```

## Backend Notes

This app's backend structure is based off of [Laravel Beyond CRUD](https://stitcher.io/blog/laravel-beyond-crud), which details the structure of projects at Spatie in reasonable detail. I'll be leaning on these patterns and spatie packages heavily here.

PHP code symbol maps are auto-generated on `composer update`, `composer install` and after `git checkout`.

### 3rd party packages I'm using

- [bugsnag/bugsnag-laravel](https://github.com/bugsnag/bugsnag-laravel)
- [itsgoingd/clockwork](https://github.com/itsgoingd/clockwork)
- [jrm2k6/cloudder](https://github.com/jrm2k6/cloudder)
- [laradock/laradock](https://github.com/laradock/laradock)
- [spatie/data-transfer-object](https://github.com/spatie/data-transfer-object)
- [spatie/laravel-activitylog](https://github.com/spatie/laravel-activitylog)
- [spatie/laravel-enum](https://github.com/spatie/laravel-enum)
- [spatie/laravel-model-states](https://github.com/spatie/laravel-model-states)
- [spatie/laravel-queueable-action](https://github.com/spatie/laravel-queueable-action)

#### Dev only packages

- [barryvdh/laravel-ide-helper](https://github.com/barryvdh/laravel-ide-helper)
- [codedungeon/phpunit-result-printer](https://github.com/mikeerickson/phpunit-pretty-result-printer)
- [psalm/laravel-psalm-plugin](https://github.com/psalm/laravel-psalm-plugin)
- [tightenco/tlint](https://github.com/tightenco/tlint)
- [vimeo/psalm](https://github.com/vimeo/psalm)

## Frontend Notes

This app's frontend is based off of [Laravel-Nuxt](https://github.com/cretueusebiu/laravel-nuxt), so feel free to check their documentation regarding any issues with the frontend setup.
