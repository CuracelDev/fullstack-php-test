## Setup

Same way you would install a typical laravel application.

    composer install

    npm install

    php artisan migrate --seed

    php artisan serve

The UI is displayed on the root page

Don't forget to run `npm run dev` after modifying the vue component.

## Extra Notes
This is a Laravel 8 and Vue 2 project. You may encounter difficulties during installation expecially if your PC is using the lastest node and PHP.

Before proceeding with setup, make sure to downgrade you php version to V7.4 and node version to v18.19.1. you can use nvm or brew if you are mac.

during installation you may encounter legacy issues with node packages, try add `--legacy-peer-deps` after the installation command.

create your database and make sure your app environment is well set including mail credentials. you can use `mailtrap` for testing.

run `php artisan key:generate` to generate application key

HMO
ramona.rice@example.net
pass123

Provider:
huels.francisca@example.org
pass123


### Testing
- Create env.testing environment file
- setup your test database (test must not be same as main database)
- Backend test (`php artisan test`) 
- Frontend Test (`npm test`)



