# About News Aggregator
News Aggregator is laravel api based application. It gets the latest news/articles from popular news providers from around the world.

# Environment Setup

- Setup redis (https://hub.docker.com/_/redis)
```
$ docker pull redis
$ docker run --name redis -d redis
```
- Setup MySql (https://hub.docker.com/_/mysql)
```
$ docker pull mysql
$ docker run --name mysql -e MYSQL_ROOT_PASSWORD=password -d mysql:tag
```
- Setup .env file with required environment variables. Check .env.example

- Run the project
```
$ docker-compose up --build -d
```
# API Documentation
Click on the button below to see list of available endpoints

[<img src="https://run.pstmn.io/button.svg" alt="Run In Postman" style="width: 128px; height: 32px;">](https://god.gw.postman.com/run-collection/4543169-ea5e1c77-ebfc-4b75-a132-70732ca0959b?action=collection%2Ffork&source=rip_markdown&collection-url=entityId%3D4543169-ea5e1c77-ebfc-4b75-a132-70732ca0959b%26entityType%3Dcollection%26workspaceId%3D1e51139c-4324-4ab9-b3e6-8c561a988df4)

Unable to click the button? [visit collection](https://www.postman.com/olayinka-raheem/news-aggregator-api/documentation/ycr6l0x/news-aggregator)

# Running Tests
From the terminal, run
```
$ ./vendor/bin/pest
```
OR
```
$ php artisan test
```

#
Note: The application is integrated to The Guardian API, New York Times and NewsApi.Currently the application gets news updates via a schedule that runs every 6 hours a day.