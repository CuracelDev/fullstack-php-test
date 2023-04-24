# Curacel PHP Test Assignment.

## Introduction

Hi there 👋 <br>
Welcome to my task submission for the PHP test assessment. This project is a simple monolithic web application built with Laravel (v8) and Vue 2

## Task Description

The task is to build a simple web application for submitting and batching orders between HMOs and their providers. It features the use of a MySQL database for storing data and an inline filesystem cache for caching.

## Prerequisites

Running this application locally requires the following:

-   NPM (Node Package Manager)
-   Composer (version 2 and above)
-   PHP 7+
-   Node v16+

## Setup Instructions

-   Clone the repository:

```
git clone https://github.com/prismathic/curacel-fullstack-php-test.git
```

-   Install Composer dependencies

```
composer install
```

-   Install NPM dependencies

```
npm install
```

-   Copy the sample environment variables and generate an application key

```
cp .env.example .env && php artisan key:generate
```

-   Set the values for your database connection in the env

```
DB_HOST=
DB_PORT=
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=
```

-   Run the migration command and seed the default HMOs

```
php artisan migrate && php artisan db:seed --class=HmoSeeder
```

-   Build the necessary Javascript assets needed for the frontend

```
npm run dev
```

-   Now you're ready to run the application 🎉

```
php artisan serve
```

-   To run tests:

```
php artisan test (backend)

npm run test (frontend)
```

<p>Happy testing 🎉</p>
