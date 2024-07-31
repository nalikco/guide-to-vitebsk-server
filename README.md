# Guide to Vitebsk Server on Laravel

## Configuration

For more convenient work with commands, you can install a Taskfile: https://taskfile.dev/installation/.

After this, when you run the task command in the project root, you will be shown a list of available commands.

## First start

### Building

At initial launch or after updates, you need to collect images.
You can do this in two ways:

Build with a separate command:

```shell
task build
```

Running containers with forced image build:

```shell
task up -- --build
```

### Installing dependencies

You must run Composer and NPM to install dependencies.
Also, there are two ways.

Installing development dependencies:

```shell
task composer -- install
```

Installing only production dependencies:

```shell
task composer -- install --no-dev
```

### Running Migrations

To keep the database structure up to date, you need to run migrations:

```shell
task artisan -- migrate --force
```

The `--force` flag allows you to bypass the warning in production mode.

### Creating a symbolic link to the storage

To make the uploaded content visible from the outside, you need to create a symbolic link to `storage/app/public`
in `public`:

```shell
task artisan -- storage:link
```

### Permissions

Finally, the last step is to set the necessary directory rights for the application to work correctly:

```shell
task chown
```

### Launching the application

To start, you need to run the command:

```shell
task up -- -d
```

The `-d` flag allows you to run containers in `detached` mode, i.e. in the background.
