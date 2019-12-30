# mvm

A tool for mapping out and analyzing 2D metroidvania games where progression depends on locks and keys.

## Getting started

```bash
git clone git@github.com:DigitalMachinist/mvm.git
git submodule update --init --recursive
composer install
npm install
composer run docker-up
```

## Backend Tools

Laravel IDE symbol maps are auto-generated on `composer update`.

This project uses [Laradock](https://laradock.io/) to host a local dev environment via docker. The laradock project is linked as a submodule and can be updated/pulled using:

```bash
git submodule update --init --recursive
```

To start hosting the app via docker:

```bash
composer run docker-up
```

To stop docker:

```bash
composer run docker-down
```

To dump out the docker network logs:

```bash
composer run docker-logs
```

To lint the app for style issues (only for the current diff without `-all`):

```bash
composer run lint[-all]
```

To run static analysis:

```bash
composer run psalm
```

To run tests:

```bash
phpunit
```

See [http://mvm.test/__clockwork](http://mvm.test/__clockwork) to view performance info.

See [http://mvm.test/log-viewer](http://mvm.test/log-viewer) to view the activity log.

See [http://mvm.test/horizon](http://mvm.test/horizon) to view info about queues/workers.

See [https://www.algolia.com/apps/Z0DB271DZ3/dashboard](https://www.algolia.com/apps/Z0DB271DZ3/dashboard) for the Algolia dashboard.

See [https://app.bugsnag.com/axon-interactive/mvm](https://app.bugsnag.com/axon-interactive/mvm) for the Bugsnag dashboard.

See [https://cloudinary.com/console/welcome](https://cloudinary.com/console/welcome) for the Cloudinary dashboard.
