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

This repository was originally based on my wiki article [Yii3 - How to start](https://www.yiiframework.com/wiki/2581/yii3-how-to-start).
In the future it may contain more ideas than the Wiki.

> I will be using Docker instead of any other local server technologies so your project will be future-proof.
> If you don't have Docker, I recommend installing the latest version of Docker Desktop:
> - https://docs.docker.com/get-started/introduction/get-docker-desktop/


> Yii3 offers more basic applications: Web, Console, API. I will be using the API application:
> - https://github.com/yiisoft/app-api
> - Other apps are linked on the page


# Running the demo application
You may be surprised that docker-compose.yml is missing in the root.
Instead, the "make" commands were prepared by the authors.
If you run both basic commands as mentioned in the documentation:

- make composer update
- make up

... then the web will be available on URL
- http://localhost:80
- If run via browser, XML is returned
- If run via Postman or Ajax, JSON is returned

