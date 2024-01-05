


## Setup

Same way you would install a typical laravel application.

    composer install

    npm install

    php artisan serve

The UI is displayed on the root page

Don't forget to run `npm run dev` after modifying the vue component.

## Setup With Docker

To ensure all the necessary tools needed for the development are available and to maintain environment consistency, 
the application can be developed with [Docker](https://docker.com/).

#### Add [Laradock](http://laradock.io/) as submodule

```
git pull --recurse-submodules
```

#### Navigate to laradock dir

```
cd laradock
```

#### Make a copy of Laradock .env
```
copy .env.example .env
```

The application is developed in php7.4 and node 16.13.2 environment, it is recommended to also run it in a similar 
environment to avoid dependency conflicts. These versions can be adjusted in the ```laradock/.env``` file by updating 
the following keys:

```
PHP_VERSION=7.4
WORKSPACE_NODE_VERSION=16.13.2
```

#### Create and start the containers

We need nginx, mysql and workspace containers running. The workspace container already contains necessary softwares 
requires to successfully run a Laravel project, e.g PHP CLI, Composer, Node, e.t.c.

```
docker-compose up -d nginx mysql workspace
```

#### Open workspace bash

```
docker-compose exec workspace bash
```

Continue running the following commands In the workspace bash...

#### Install composer dependencies

```
composer install
```

#### Generate application key

```
php artisan key:generate
```

#### Migrate database

```
php artisan migrate
```

#### Seed Database with HMOs

```
php artisan db:seed --class=HmoSeeder
```

#### Install Javascript dependencies

```
npm install
```

#### Compile assets

```
npm run dev
```


#### Update application .env
In app .env file, set the following...
```
DB_CONNECTION=mysql
DB_HOST=mysql
DB_DATABASE=default
DB_USERNAME=root
DB_PASSWORD=root
```



## Post Setup

#### Notifications

Mailing credentials should be provided in the env for email notification to work. 
You can use a credential from [Mailtrap](https://mailtrap.io/) for testing.

#### Queues
Actions such as batching orders, processing orders and sending notifications are queued, the queue worker needs to be up
to pick and complete those actions.

```
php artisan queue:work redis --queue=notifications,batchers,order
```


## Testing

There is a feature test for creating order via api and unit tests for batching
order by encounter date and by order create date.
```
php artisan test
```

For the frontend in vuejs, tests are available for the button component and widgets for submitting order using [jest](https://jestjs.io/)
```
npm run test
```
