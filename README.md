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
