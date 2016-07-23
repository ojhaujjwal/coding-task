Coding task for Software Engineer
===================================
[![Master Branch Build Status](https://travis-ci.org/ojhaujjwal/coding-task.svg?branch=master)](http://travis-ci.org/ojhaujjwal/coding-task)
[![Code Climate](https://codeclimate.com/github/ojhaujjwal/coding-task/badges/gpa.svg)](https://codeclimate.com/github/ojhaujjwal/coding-task)
[![StyleCI](https://styleci.io/repos/63389061/shield)](https://styleci.io/repos/63389061)

This is a coding task from [bit.ly/sw-eng-task](bit.ly/sw-eng-task) developed using [Laravel 5](https://laravel.com/docs/5.2).

## Requirements
* PHP >= 5.5.9
* OpenSSL PHP Extension
* PDO PHP Extension
* Mbstring PHP Extension
* Tokenizer PHP Extension

## Installation
* Clone the repo.
* Run `composer install`
* Run `composer setup`

## Directory Permissions
After installation, you may need to configure some permissions. Directories within the storage and the bootstrap/cache directories should be writable by your web server or the application will not run.

## Docker

For development, we use [docker-compose](https://docs.docker.com/compose/);
make sure you have both docker-compose and Docker installed on your machine.

```bash
$ cd laradock
$ docker-compose up -d nginx
```

This will create some containers. Run `docker-compose ps` to list the containers and the information. This will also display all the exposed ports. Access the port exposed by nginx container to access the application through a web browser.

To execute commands like (Artisan, Composer, PHPUnit, Gulp, ...), you need to execute a special workspace container. Again, run `docker-compose ps` to find out the Workspace container name.

```bash
$ docker exec -it {Workspace-Container-Name} bash
```

Replace {Workspace-Container-Name} with your Workspace container name. 

You can also run the commands like phpunit directly using:

```bash
$ docker exec {Workspace-Container-Name} vendor/bin/phpunit
```

## Demo
For demo, you can visit [188.166.134.66](http://188.166.134.66/).
