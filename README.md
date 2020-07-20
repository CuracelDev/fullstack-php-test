## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes.

## Installation


After cloning the application, you need to install it's dependencies.

```
$ composer install
$ npm install && npm run dev
```

## Setup

When you are done with installation, copy the .env.example file to .env

```
$ cp .env.example .env
```

Generate the application key

```
$ php artisan key:generate
```

Create database connection

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_db_name
DB_USERNAME=your_db_username
DB_PASSWORD=your_db_password
```

Run database migrations

```
$ php artisan migrate
```

Seed database with dummy data

```
$ php artisan db:seed
```

Run tests

```
$ ./vendor/bin/phpunit
```

Run the app

```
$ php artisan serve
```

## Built With

-   Laravel - The PHP framework for building the API endpoints needed for the application
-   Vue - The Progressive JavaScript Framework for building interactive interfaces
