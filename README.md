<p align="center">
    <a href="https://github.com/yiisoft" target="_blank">
        <img src="https://yiisoft.github.io/docs/images/yii_logo.svg" height="100px" alt="Yii">
    </a>
    <h1 align="center">Yii3 API application</h1>
    <h3 align="center">The application template for a new API project</h3>
    <br>
</p>

This project extends the official [Yii3 API application](https://github.com/yiisoft/app-api)
and adds features that I need in every project.
If you need basic info about the original application, open their repository and scroll down.

This repository was originally based on my wiki article
[Yii3 - How to start](https://www.yiiframework.com/wiki/2581/yii3-how-to-start).
In the future it may contain more ideas than the Wiki.

> I will be using Docker instead of any other local server technologies so your project will be future-proof.
> If you don't have Docker, I recommend installing the latest version of Docker Desktop:
> - https://docs.docker.com/get-started/introduction/get-docker-desktop/


> Yii3 offers more basic applications: Web, Console, API. I will be using the API application:
> - https://github.com/yiisoft/app-api
> - Other apps are linked on the page

# Running the application

You may be surprised that docker-compose.yml is missing in the root.
Instead, the "make" commands were prepared by the authors.
If you run both basic commands as mentioned in the documentation:

- make composer update
- make up

... then the web will be available on your localhost.
The port is defined in [docker/dev/compose.yml](docker/dev/compose.yml) and in [docker/.env](docker/.env)

- If run via browser, XML is returned
- If run via Postman or Ajax, JSON is returned

# My changes

## Docker containers

As you can see in file [docker/dev/compose.yml](docker/dev/compose.yml), I added some containers:

- MariaDB
- Composer - now `composer install` should be called automatically when you call `make up`. It is a copy of the `app`
  container.
- Adminer - the famous single-file DB browser. See [their web](https://www.adminer.org/en/).
    - Yes, adminer.php could be manually places into the public folder, but it could be blocked by your Debugger.
      Separate container avoids this.
    - Adminer will be available on
      URL [http://localhost:9081/?server=db&username=db&db=db](http://localhost:9081/?server=db&username=db&db=db).
    - Correct port is again in [docker/.env](docker/.env), MariaDB login
      in [docker/dev/compose.yml](docker/dev/compose.yml)

If you make any changes in your docker setup, just call following commands to restart:

- make down
- make build
- make up
    - This will run all containers, but the composer-container will automatically die as soon as `composer install`
      finishes.
    - run `docker ps` to verify

Why did I change the web port?
Because later you may run 4 different projects at the same time and all cannot run on port 80.

## MariaDB + migrations

These composer packages were added using the "make" command:

- [yiisoft/db-migration](https://github.com/yiisoft/db-migration)
- [yiisoft/db-mysql](https://github.com/yiisoft/db-mysql)
- [yiisoft/cache](https://github.com/yiisoft/cache)

Now you can call `make yii list` and you will see migration commands.
When creating a new migration, the best way is:

- `make yii "migrate:create user --command=table"`
- Do not forget about the quotes, otherwise "make" will understand it incorrectly

> Note:
> Compared to Yii2, migration names are not nice (example `M251013085231CreateUserTable.php`). They are created using
> method generateClassName() in `vendor/yiisoft/db-migration/src/Service/MigrationService.php`.

The DB connection is defined in file [docker/.env](docker/.env) and is pushed into containers so it can be reused.
I feel the connection should be defined in the dev-related .env file, but it didn't work for me. I will investigate.

Note:
If I restart the containers using make down, build + up, then the command "make yii migrate:up"
sometimes cannot connect to the DB. Additional restart helped. I will have to test again.

## Seeding

For seeding the DB, I used these packages:

- [fakerphp/faker](https://github.com/FakerPHP/Faker)
- [yiisoft/security](https://github.com/yiisoft/security)

Check `src/Console/SeedCommand.php` + `config/console/commands.php`.

Seeding is executed by command `make yii seed`. List of all available commands is here: `make yii list`.

## Reading/writing data from/to DB 

In Yii we were always using ActiveRecord and its models, but in Yii3 the package is not ready yet.
The (temporary) solution is to use the existing class `Yiisoft\Db\Query\Query` for reading - see [src/Entity/BaseRepository.php](src/Entity/BaseRepository.php).

Writing is done in [src/Console/SeedCommand.php](src/Console/SeedCommand.php) using `Yiisoft\Db\Mysql\Command`.
